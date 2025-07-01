<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

use App\Models\Product;
use App\Models\Setting;


class PengaturanHarga extends Component
{
    use WithFileUploads;
    #[Layout('components.layouts.dashboard')]

    //modals
    public $isInputModalOpen = false;
    public $isNotificationModalOpen = false;

    //properties tracking perubahan harga produk
    public $harga_produk = [];
    public $original_price = [];

    public $harga_membership_per_bulan;
    public $harga_pengunjung_harian;
    public $original_harga_membership_per_bulan;
    public $original_harga_pengunjung_harian;

    // Tambah properties untuk foreign membership
    public $foreign_1_week;
    public $foreign_2_weeks;
    public $foreign_3_weeks;
    public $foreign_1_month;
    public $original_foreign_1_week;
    public $original_foreign_2_weeks;
    public $original_foreign_3_weeks;
    public $original_foreign_1_month;

    //tambahan properti untuk daily visit fee foreign
    public $harga_pengunjung_harian_foreign;
    public $original_harga_pengunjung_harian_foreign;

    // Tambah properties untuk local membership
    public $local_1_week;
    public $local_2_weeks;
    public $local_3_weeks;
    public $local_1_month;
    public $original_local_1_week;
    public $original_local_2_weeks;
    public $original_local_3_weeks;
    public $original_local_1_month;


    public $products;

    //form properties
    public $image = null;
    public $name;
    public $description;
    public $price;


    public function mount()
    {
        $this->harga_membership_per_bulan = Setting::get('base_monthly_membership_fee', 0);
        $this->harga_pengunjung_harian = Setting::get('daily_visit_fee', 0);
        $this->harga_pengunjung_harian_foreign = Setting::get('daily_visit_fee_foreign', 0);

        // Load foreign membership prices
        $this->foreign_1_week = Setting::get('foreign_membership_1_week', 0);
        $this->foreign_2_weeks = Setting::get('foreign_membership_2_weeks', 0);
        $this->foreign_3_weeks = Setting::get('foreign_membership_3_weeks', 0);
        $this->foreign_1_month = Setting::get('foreign_membership_1_month', 0);

        // Load local membership prices
        $this->local_1_week = Setting::get('local_membership_1_week', 0);
        $this->local_2_weeks = Setting::get('local_membership_2_weeks', 0);
        $this->local_3_weeks = Setting::get('local_membership_3_weeks', 0);
        $this->local_1_month = Setting::get('local_membership_1_month', 0);

        $this->original_harga_membership_per_bulan = $this->harga_membership_per_bulan;
        $this->original_harga_pengunjung_harian = $this->harga_pengunjung_harian;
        $this->original_harga_pengunjung_harian_foreign = $this->harga_pengunjung_harian_foreign;

        // Save original foreign prices
        $this->original_foreign_1_week = $this->foreign_1_week;
        $this->original_foreign_2_weeks = $this->foreign_2_weeks;
        $this->original_foreign_3_weeks = $this->foreign_3_weeks;
        $this->original_foreign_1_month = $this->foreign_1_month;

        // Save original local prices
        $this->original_local_1_week = $this->local_1_week;
        $this->original_local_2_weeks = $this->local_2_weeks;
        $this->original_local_3_weeks = $this->local_3_weeks;
        $this->original_local_1_month = $this->local_1_month;

        $this->loadProducts();
    }

    public function render()
    {
        if ($message = session('message')) {
            $this->isNotificationModalOpen = true;
        }

        return view('livewire.pengaturan-harga');
    }

    //modals helper

    public function toggleInputModal()
    {
        $this->isInputModalOpen = !$this->isInputModalOpen;
    }

    public function closeNotificationModal()
    {
        $this->isNotificationModalOpen = false;
    }

    public function resetInput()
    {
        $this->reset(['name', 'description', 'price', 'image']);
        $this->isInputModalOpen = false;
    }


    //loader
    public function loadProducts()
    {
        $this->products = Product::all();

        foreach ($this->products as $product) {
            $this->harga_produk[$product->id] = $product->price;
            $this->original_price[$product->id] = $product->price;
        }
    }
    public function updateProductPrice($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $product->update([
                'price' => $this->harga_produk[$productId]
            ]);

            $this->original_price[$productId] = $this->harga_produk[$productId];

            session()->flash('message', [
                'type' => 'success',
                'title' => 'Harga Berhasil Diperbarui',
                'description' => 'Harga produk ' . $product->name . ' telah diperbarui.',
            ]);
        }
    }
    public function resetProductPrice($productId)
    {
        $this->harga_produk[$productId] = $this->original_price[$productId];
    }
    public function hasChangedPrice($productId)
    {
        return isset($this->harga_produk[$productId]) && isset($this->original_price[$productId]) && $this->harga_produk[$productId] !== $this->original_price[$productId];
    }


    //settings methods
    public function saveSettings()
    {
        $this->validate([
            'harga_membership_per_bulan' => 'required|numeric|min:0',
            'harga_pengunjung_harian' => 'required|numeric|min:0',
            'harga_pengunjung_harian_foreign' => 'required|numeric|min:0',
            'foreign_1_week' => 'required|numeric|min:0',
            'foreign_2_weeks' => 'required|numeric|min:0',
            'foreign_3_weeks' => 'required|numeric|min:0',
            'foreign_1_month' => 'required|numeric|min:0',
            'local_1_week' => 'required|numeric|min:0',
            'local_2_weeks' => 'required|numeric|min:0',
            'local_3_weeks' => 'required|numeric|min:0',
            'local_1_month' => 'required|numeric|min:0',
        ]);

        Setting::set('base_monthly_membership_fee', $this->harga_membership_per_bulan);
        Setting::set('daily_visit_fee', $this->harga_pengunjung_harian);
        Setting::set('daily_visit_fee_foreign', $this->harga_pengunjung_harian_foreign);

        Setting::set('foreign_membership_1_week', $this->foreign_1_week);
        Setting::set('foreign_membership_2_weeks', $this->foreign_2_weeks);
        Setting::set('foreign_membership_3_weeks', $this->foreign_3_weeks);
        Setting::set('foreign_membership_1_month', $this->foreign_1_month);

        Setting::set('local_membership_1_week', $this->local_1_week);
        Setting::set('local_membership_2_weeks', $this->local_2_weeks);
        Setting::set('local_membership_3_weeks', $this->local_3_weeks);
        Setting::set('local_membership_1_month', $this->local_1_month);

        $this->original_harga_membership_per_bulan = $this->harga_membership_per_bulan;
        $this->original_harga_pengunjung_harian = $this->harga_pengunjung_harian;
        $this->original_harga_pengunjung_harian_foreign = $this->harga_pengunjung_harian_foreign;

        $this->original_foreign_1_week = $this->foreign_1_week;
        $this->original_foreign_2_weeks = $this->foreign_2_weeks;
        $this->original_foreign_3_weeks = $this->foreign_3_weeks;
        $this->original_foreign_1_month = $this->foreign_1_month;

        $this->original_local_1_week = $this->local_1_week;
        $this->original_local_2_weeks = $this->local_2_weeks;
        $this->original_local_3_weeks = $this->local_3_weeks;
        $this->original_local_1_month = $this->local_1_month;

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Pengaturan Disimpan',
            'description' => 'Pengaturan harga telah berhasil disimpan.',
        ]);
    }


    //product method
    public function toggleAvailableProduct($productId)
    {
        if ($product = Product::find($productId)) {
            $product->is_available = !$product->is_available;
            $product->save();

            if ($product->is_available) {
                session()->flash('message', [
                    'type' => 'success',
                    'title' => 'Produk Tersedia',
                    'description' => 'Produk ' . $product->name . ' diaktifkan.',
                ]);
            } else {
                session()->flash('message', [
                    'type' => 'success',
                    'title' => 'Produk Tidak Tersedia',
                    'description' => 'Produk ' . $product->name . ' dinonaktifkan.',
                ]);
            }
        }
    }
    // Handle file upload
    public function addProduct()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $product = new \App\Models\Product();
        $product->name = $this->name;
        $product->description = $this->description;
        $product->price = $this->price;

        if ($this->image) {
            $product->image = $this->image->store('images', 'public');
        }

        $product->save();

        // Reset fields
        $this->resetInput();
        $this->isInputModalOpen = false;

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Produk Ditambahkan',
            'text' => 'Produk baru telah berhasil ditambahkan.',
        ]);
    }


    // Handle file remove
    public function removeImage()
    {
        if ($this->image) {
            $this->image->delete();
            $this->image = null;
        }
    }
}
