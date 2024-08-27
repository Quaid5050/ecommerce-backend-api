<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrinterModelRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255|unique:printer_models,name',
            'series_id' => 'required|integer|exists:series,id',
        ];

        // Additional rules for updates (e.g., unique check)
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['name'] = 'required|string|max:255|unique:printer_models,name,' . $this->route('printer_model')->id;
        }

        return $rules;
    }
}
