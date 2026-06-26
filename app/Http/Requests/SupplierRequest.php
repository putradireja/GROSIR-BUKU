<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('supplier') ? $this->route('supplier')->id : null;
        return [
            'kode' => 'required|string|max:50|unique:suppliers,kode,' . $id,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ];
    }
}