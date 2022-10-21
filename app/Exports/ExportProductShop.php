<?php

namespace App\Exports;

use App\Models\ProductShop;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportProductShop implements FromView
{
  public function __construct($startDate, $endDate, $shop_id)
  {
      $this->startDate = $startDate;
      $this->endDate = $endDate;
      $this->shop_id = $shop_id;
  }

  public function view(): View
  {
      if ($this->shop_id == "") {
          return view('pages.product_shop.template_excel', [
              'product_shops' => ProductShop::whereBetween('created_at', [$this->startDate, $this->endDate])
              ->get()
          ]);
      } else {
          return view('pages.product_shop.template_excel', [
              'product_shops' => ProductShop::whereBetween('created_at', [$this->startDate, $this->endDate])
              ->where('shop_id', $this->shop_id)
              ->get()
          ]);
      }
  }
}
