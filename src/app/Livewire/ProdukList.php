<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\Produk;
use Livewire\Component;

class ProdukList extends Component
{
    public string $search = '';

    public string $kategori = '';

    public function render()
    {
        $produks = Produk::query()
            ->with('kategori')
            ->when($this->kategori, function ($query) {
                $query->whereHas('kategori', function ($q) {
                    $q->where('slug', $this->kategori);
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('merk', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->get();

        return view('livewire.produk-list', [
            'produks' => $produks,
            'kategoris' => Kategori::latest()->get(),
        ]);
    }
}