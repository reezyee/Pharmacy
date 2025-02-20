<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'pembuat' => 'required|string|max:255',
            'nie' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
            'deskripsi_obat' => 'required|string',
            'indikasi_obat' => 'required|string',
            'kontraindikasi_obat' => 'required|string',
            'aturan_pakai' => 'required|string',
            'efek_samping' => 'required|string',
            'dosis_obat' => 'required|string|max:255',
            'kekuatan_obat' => 'required|string|max:255',
            'komposisi_obat' => 'required|string',
            'banyak' => 'required|integer',
            'sisa' => 'required|integer',
            'harga' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'tanggal_kedaluwarsa' => 'required|date',
            'is_available' => 'boolean',
        ];
    }
}
