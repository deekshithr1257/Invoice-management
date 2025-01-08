<?php

namespace App\Http\Requests;

use App\Invoice;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        $rules = [
            'supplier_id'     => [
                'required',
            ],
            'invoice_number'     => [
                'required',
                'unique:invoices,invoice_number'
            ],
            'entry_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'amount'     => [
                'required',
            ],
            'original_amount' => [
                'required',
            ],
            'discount_type' => [
                'required',
            ],
            'created_by'     => [
                'required',
            ],
            'image_files'    => [
                'required_without:camera_images','array'
            ],
            'image_files.*' => [
                'image','mimes:jpeg,png,jpg,gif,svg,webp'
            ],
            'camera_images'     => [
                'required_without:image_files','array'
            ],
            'camera_images.*' => [
                'image','mimes:jpeg,png,jpg,gif,svg'
            ],
        ];


        if ($this->input('discount_type') !== 'none') {
            $rules['discount'] = ['required', 'numeric', 'min:0'];
        }

        return $rules;
    }
}
