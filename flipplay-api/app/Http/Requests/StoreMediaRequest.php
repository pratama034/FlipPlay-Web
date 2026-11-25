<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isPatch = $this->isMethod('PATCH');
        $presenceRules = $isPatch ? ['sometimes', 'required'] : ['required'];

        $titleUniqueRule = $isPatch
            ? Rule::unique('media', 'title')->ignore($this->route('media'))
            : Rule::unique('media', 'title');

        return [
            'title' => [...$presenceRules, 'string', 'max:255', $titleUniqueRule],
            'type' => [...$presenceRules, 'in:anime,manga'],
            'genre' => [...$presenceRules, 'string', 'max:100'],
            'release_year' => [...$presenceRules, 'integer', 'min:1900'],
            'total_units' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Pesan error validasi kustom berbahasa Indonesia (422 Unprocessable Entity).
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi.',
            'title.string' => 'Judul media harus berupa teks.',
            'title.max' => 'Judul media maksimal terdiri dari 255 karakter.',
            'title.unique' => 'Judul media sudah terdaftar di dalam katalog.',
            'type.required' => 'Tipe media wajib diisi.',
            'type.in' => 'Tipe media hanya boleh bernilai anime atau manga.',
            'genre.required' => 'Genre media wajib diisi.',
            'genre.string' => 'Genre media harus berupa teks.',
            'genre.max' => 'Genre media maksimal terdiri dari 100 karakter.',
            'release_year.required' => 'Tahun rilis wajib diisi.',
            'release_year.integer' => 'Tahun rilis harus berupa angka bulat.',
            'release_year.min' => 'Tahun rilis minimal adalah tahun 1900.',
            'total_units.integer' => 'Jumlah episode/chapter harus berupa angka bulat.',
            'total_units.min' => 'Jumlah episode/chapter minimal bernilai 1.',
            'status.string' => 'Status media harus berupa teks.',
            'description.string' => 'Deskripsi media harus berupa teks.',
        ];
    }
}
