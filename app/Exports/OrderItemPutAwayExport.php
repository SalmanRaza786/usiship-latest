<?php
namespace App\Exports;

use App\Models\OrderItemPutAway;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderItemPutAwayExport implements FromCollection, WithHeadings, WithMapping
{
    protected $orderId;

    // Constructor to accept the order_id
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    // Fetch the data to be exported based on order_id
    public function collection()
    {
        return OrderItemPutAway::where('order_id', $this->orderId)->get();
    }

    // Define the headings for the Excel sheet
    public function headings(): array
    {
        return [
            'Sr No.',
            'Order ID',
            'Item Name',
            'SKU',
            'Quantity',
            'Pallet#',
            'Location',
        ];
    }

    // Map the data to match the headings
    public function map($itemPutAway): array
    {
        static $srNo = 1;
        return [
            $srNo++,
            $itemPutAway->order->order_id ?? "",
            $itemPutAway->inventory->item_name  ?? "",  // Assuming 'item_name' is a column
            $itemPutAway->inventory->sku  ?? "",  // Assuming 'item_name' is a column
            $itemPutAway->qty  ?? "",   // Assuming 'quantity' is a column
            $itemPutAway->pallet_number  ?? "",   // Assuming 'location' is a column
            $itemPutAway->location->loc_title  ?? "",   // Assuming 'location' is a column

        ];
    }
}
