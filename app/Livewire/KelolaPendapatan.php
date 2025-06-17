<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\User;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class KelolaPendapatan extends Component
{
    use WithPagination;
    #[Layout('components.layouts.dashboard')]

    // Properties for managing income
    public $transaction_type = '';
    public $selectedMember = '';
    public $member_type = '';
    public $duration_membership = '';
    public $description = '';
    public $payment_method = '';
    public $visitor_type = 'local';

    // properties for options
    public $memberOptions = [];
    public $memberTypeOptions = [];
    public $durationOptions = [];

    public $selectedMemberData = null;

    //properties penjuala barang tambahan
    public $products = [];
    public $selectedProducts = [];
    public $totalAmount = 0;

    public $membershipTotal = 0;
    public $dailyVisitTotal = 0;

    //properties untuk data transaksi hari ini
    public $totalToday = 0;
    public $membershipToday = 0;
    public $otherToday = 0;

    //properties untuk pagination
    public $perPage = 10;
    public $showPagination = true;

    //modals
    public $isNotificationModalOpen = false;


    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->initializeOptions();
        $this->loadProducts();
        $this->loadSettings();
        $this->loadTodayTotals();
    }

    public function render()
    {
        if ($message = session('message')) {
            $this->isNotificationModalOpen = true;
        }


        return view('livewire.kelola-pendapatan', [
            'todayTransactions' => $this->todayTransactions,
        ]);
    }


    private function initializeOptions()
    {
        // Load member yang statusnya bukan 'active'
        $this->memberOptions = User::where('role', 'member')
            ->where('status', '!=', 'active')
            ->where('status', '!=', 'pending_email_verification')
            ->get(['id', 'name', 'email', 'member_type', 'status']);

        // Options untuk member type
        $this->memberTypeOptions = [
            'local' => 'Local',
            'foreign' => 'Foreign'
        ];

        // Options untuk durasi membership (khusus foreign)
        $this->durationOptions = [
            'one_week' => '1 Minggu',
            'two_weeks' => '2 Minggu',
            'three_weeks' => '3 Minggu',
            'one_month' => '1 Bulan'
        ];
    }

    private function loadSettings()
    {
        $this->calculateDailyVisitTotal();
    }

    public function loadProducts()
    {
        $this->products = Product::where('is_available', true)
            ->get();
    }

    public function loadTodayTotals()
    {

        $this->totalToday = Transaction::whereDate('transaction_datetime', today())
            ->sum('total_amount');

        $this->membershipToday = Transaction::whereDate('transaction_datetime', today())
            ->where('transaction_type', 'membership_payment')
            ->sum('total_amount');

        $this->otherToday = Transaction::whereDate('transaction_datetime', today())
            ->where('transaction_type', ['additional_items_sale', 'daily_visit_fee'])
            ->sum('total_amount');
    }

    // public function getTodayTransactions()
    // {
    //     return Transaction::with('user:id,name, email')
    //         ->whereDate('transaction_datetime', today())
    //         ->orderBy('transaction_datetime', 'desc')
    //         ->paginate($this->perPage, pageName: 'transactionPage');
    // }

    public function getTodayTransactionsProperty()
    {
        return Transaction::with(['user:id,name,email'])
            ->whereDate('transaction_datetime', today())
            ->orderBy('transaction_datetime', 'desc')
            ->paginate($this->perPage);
    }



    // Method transaksi harian
    public function calculateDailyVisitTotal()
    {
        if ($this->visitor_type === 'foreign') {
            $this->dailyVisitTotal = Setting::get('daily_visit_fee_foreign', 30000);
        } else {
            $this->dailyVisitTotal = Setting::get('daily_visit_fee', 15000);
        }
    }

    public function updatedVisitorType($value)
    {
        $this->calculateDailyVisitTotal();
    }

    //method transaksi additional items sale
    public function addProductToCart($productId)
    {
        $product = Product::find($productId);
        if ($product && $product->is_available) {
            if (isset($this->selectedProducts[$productId])) {
                // Jika produk sudah ada di cart, tambahkan quantity
                $this->selectedProducts[$productId]['quantity']++;
            } else {
                $this->selectedProducts[$productId]  = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'subTotal' => $product->price
                ];
            }

            $this->updatedSubTotal($productId);
            $this->calculateTotal();
        }
    }
    public function updateQuantity($productId, $quantity)
    {
        if (isset($this->selectedProducts[$productId])) {
            if ($quantity <= 0) {
                // Jika quantity kurang dari atau sama dengan 0, hapus produk dari cart
                unset($this->selectedProducts[$productId]);
            } else {
                // Update quantity dan subTotal
                $this->selectedProducts[$productId]['quantity'] = $quantity;
                $this->updatedSubTotal($productId);
            }

            $this->calculateTotal();
        }
    }
    public function removeProduct($productId)
    {
        unset($this->selectedProducts[$productId]);
        $this->calculateTotal();
    }
    public function updatedSubTotal($productId)
    {
        if (isset($this->selectedProducts[$productId])) {
            $this->selectedProducts[$productId]['subtotal'] =
                $this->selectedProducts[$productId]['price'] *
                $this->selectedProducts[$productId]['quantity'];
        }
    }

    public function calculateTotal()
    {
        $this->totalAmount = array_sum(array_column($this->selectedProducts, 'subtotal'));
    }


    // Method transction type membership payment
    public function calculateMembershipTotal()
    {
        if (!$this->selectedMemberData) {
            $this->membershipTotal = 0;
            return;
        }
        $memberType = $this->member_type ?: $this->selectedMemberData->member_type;

        if ($memberType === 'local') {
            $this->membershipTotal = Setting::get('base_monthly_membership_fee', 0);
        } elseif ($memberType === 'foreign' && $this->duration_membership) {

            // Use fixed prices instead of percentage calculation
            switch ($this->duration_membership) {
                case 'one_week':
                    $this->membershipTotal = Setting::get('foreign_membership_1_week', 0);
                    break;
                case 'two_weeks':
                    $this->membershipTotal = Setting::get('foreign_membership_2_weeks', 0);
                    break;
                case 'three_weeks':
                    $this->membershipTotal = Setting::get('foreign_membership_3_weeks', 0);
                    break;
                case 'one_month':
                    $this->membershipTotal = Setting::get('foreign_membership_1_month', 0);
                    break;
                default:
                    $this->membershipTotal = 0;
            }
        } else {
            $this->membershipTotal = 0; // Tidak valid atau tidak ada member type
        }
    }


    public function updatedSelectedMember($value)
    {
        if ($value) {
            // Pastikan value tidak kosong dan valid
            $this->selectedMemberData = User::where('id', $value)
                ->where('role', 'member')
                ->first();

            if ($this->selectedMemberData) {
                // Jika member sudah punya member_type, set dari database
                if ($this->selectedMemberData->member_type) {
                    $this->member_type = $this->selectedMemberData->member_type;
                } else {
                    $this->member_type = '';
                }
            }

            // Reset duration setiap kali member berubah
            $this->duration_membership = '';
            $this->calculateMembershipTotal();
        } else {
            $this->selectedMemberData = null;
            $this->member_type = '';
            $this->duration_membership = '';
            $this->membershipTotal = 0;
        }
    }

    public function updatedMemberType($value)
    {
        // Reset duration ketika member type berubah
        $this->duration_membership = '';
        $this->calculateMembershipTotal();
    }

    public function updatedDurationMembership($value)
    {
        // Hitung total membership berdasarkan durasi yang dipilih
        $this->calculateMembershipTotal();
    }

    public function updatedTransactionType($value)
    {
        // Reset semua field related ketika transaction type berubah
        $this->selectedMember = '';
        $this->selectedMemberData = '';
        $this->member_type = '';
        $this->duration_membership = '';
        $this->description = '';
        $this->payment_method = '';
        $this->selectedProducts = [];
        $this->totalAmount = 0;
        $this->visitor_type = 'local';
        $this->dailyVisitTotal = 0;

        // Reload member options jika perlu
        if ($value === 'membership_payment') {
            $this->initializeOptions();
        } elseif ($value === 'additional_items_sale') {
            $this->loadProducts();
        } elseif ($value === 'daily_visit_fee') {
            $this->calculateDailyVisitTotal();
        }
    }



    public function save()
    {
        $this->validate([
            'transaction_type' => 'required',
            'selectedMember' => 'required_if:transaction_type,membership_payment',
            'member_type' => 'required_if:transaction_type,membership_payment',
            'selectedProducts' => 'required_if:transaction_type,additional_items_sale|array',
            'visitor_type' => 'required_if:transaction_type,daily_visit_fee',
            'description' => 'required_if:transaction_type,daily_visit_fee',
            'payment_method' => 'required',
        ], [
            'transaction_type.required' => 'Tipe Transaksi Tidak Boleh Kosong.',
            'selectedMember.required_if' => 'Pilih member yang akan dikenakan biaya.',
            'member_type.required_if' => 'Pilih tipe member.',
            'duration_membership.required_if' => 'Pilih durasi membership.',
            'selectedProducts.required_if' => 'Pilih setidaknya satu produk untuk dijual.',
            'description.required_if' => 'Deskripsi diperlukan untuk transaksi ini.',
            'visitor_type.required_if' => 'Pilih tipe pengunjung.',
            'payment_method.required' => 'Metode pembayaran tidak boleh kosong.',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $userId = null;
            $description = '';
            $visitorType = null;

            //  Fix assignment untuk user_id
            if ($this->transaction_type === 'membership_payment') {
                $totalAmount = $this->membershipTotal;
                $userId = $this->selectedMember;
                $memberName = $this->selectedMemberData ? $this->selectedMemberData['name'] : 'Unknown Member';
                $description = 'Pembayaran membership - ' . $this->member_type . ' - ' . $memberName;
            } elseif ($this->transaction_type === 'daily_visit_fee') {
                $totalAmount = $this->dailyVisitTotal;
                $visitorType = $this->visitor_type;
                $description = $this->description;
            } elseif ($this->transaction_type === 'additional_items_sale') {
                $totalAmount = $this->totalAmount;
                $productNames = [];
                foreach ($this->selectedProducts as $item) {
                    $productNames[] = $item['name'] . ' (' . $item['quantity'] . 'x)';
                }
                $description = 'Penjualan: ' . implode(', ', $productNames);
            }

            //  create transaction
            $transaction = Transaction::create([
                'transaction_datetime' => Carbon::now(),
                'transaction_type' => $this->transaction_type,
                'description' => $description,
                'total_amount' => $totalAmount,
                'user_id' => $userId,
                'payment_method' => $this->payment_method,
                'visitor_type' => $visitorType,
            ]);

            //Handle transaction items
            if ($this->transaction_type === 'additional_items_sale') {
                foreach ($this->selectedProducts as $productId => $item) { // PERBAIKAN: gunakan key productId
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price_per_unit' => $item['price'],
                        'sub_total' => $item['subTotal'],
                    ]);
                }
            }

            // Update member status
            if ($this->transaction_type === 'membership_payment') {

                if ($this->member_type === 'foreign') {
                    $membershipStartDate = Carbon::now();
                    $membershipExpiredDate = null;

                    if ($this->duration_membership === 'one_week') {
                        $membershipExpiredDate = $membershipStartDate->copy()->addWeek();
                    } elseif ($this->duration_membership === 'two_weeks') {
                        $membershipExpiredDate = $membershipStartDate->copy()->addWeeks(2);
                    } elseif ($this->duration_membership === 'three_weeks') {
                        $membershipExpiredDate = $membershipStartDate->copy()->addWeeks(3);
                    } elseif ($this->duration_membership === 'one_month') {
                        $membershipExpiredDate = $membershipStartDate->copy()->addMonth();
                    }
                } elseif ($this->member_type === 'local') {
                    $membershipStartDate = Carbon::now();
                    $membershipExpiredDate = Carbon::now()->addMonth();
                } else {
                    $membershipStartDate = null;
                    $membershipExpiredDate = null;
                }

                User::where('id', $this->selectedMember)->update([
                    'status' => 'active',
                    'member_type' => $this->member_type,
                    'membership_started_date' => $membershipStartDate,
                    'membership_expiration_date' => $membershipExpiredDate,

                ]);
            }

            DB::commit();


            session()->flash('message', [
                'type' => 'success',
                'title' => 'Transaksi Berhasil',
                'description' => 'Transaksi telah berhasil disimpan.',
            ]);

            $this->resetForm();
            $this->loadTodayTotals();
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollback();

            // Perbaikan 6: Log error untuk debugging
            Log::error('Transaction save error: ' . $e->getMessage());

            session()->flash('message', [
                'type' => 'error',
                'title' => 'Transaksi Gagal',
                'description' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage(),
            ]);
        }
    }

    public function closeNotificationModal()
    {
        $this->isNotificationModalOpen = false;
        // Reset form after closing the modal
        $this->resetForm();
    }


    private function resetForm()
    {
        $this->reset([
            'transaction_type',
            'member_type',
            'selectedMember',
            'duration_membership',
            'description',
            'payment_method',
            'selectedProducts',
            'totalAmount',
            'membershipTotal',
            'selectedMemberData',
            'visitor_type'
        ]);

        // Reload options
        $this->initializeOptions();
        $this->loadProducts();
        $this->loadSettings();
    }

    public function refreshTransactions()
    {
        $this->loadTodayTotals();
        session()->flash('message', [
            'type' => 'info',
            'title' => 'Refresh Berhasil',
            'description' => 'Data transaksi berhasil diperbarui.',
        ]);
    }
}
