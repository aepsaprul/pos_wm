<table border="1">
  <thead>
      <tr>
          <th style="background-color: lightblue; font-weight: bold; text-align: center;">No</th>
          <th style="background-color: lightblue; font-weight: bold; text-align: center;">Kode</th>
          <th style="background-color: lightblue; font-weight: bold; text-align: center;">Toko</th>
          <th style="background-color: lightblue; font-weight: bold; text-align: center;">Produk</th>
          <th style="background-color: lightblue; font-weight: bold; text-align: center;">Stok</th>
      </tr>
  </thead>
  <tbody>
      @foreach ($product_shops as $key => $item)
          <tr>
              <td>{{ $key + 1 }}</td>
              <td>
                @if ($item->prodcut)
                  {{ $item->product->product_code }}                    
                @endif
              </td>
              <td>
                @if ($item->shop)
                  {{ $item->shop->name }}                    
                @endif
              </td>
              <td>
                @if ($item->product)
                  {{ $item->product->productMaster->name }} - {{ $item->product->product_name }}                    
                @endif
              </td>
              <td>{{ $item->stock }}</td>
          </tr>
      @endforeach
  </tbody>
</table>
