<?php

namespace App\DataTables;

use App\Models\DeliveredOrder;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DeliveredOrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function ($query) {
            $view = "<a href='" . route('admin.orders.show', $query->id) . "' class='btn btn-primary'><i class='fas fa-eye'></i></a>";
            $status = "<a href='javascript:;' class='btn btn-warning ml-2 order_status_btn' data-id='".$query->id."'><i class='fas fa-truck-loading'></i></a>";
            $delete = "<a href='" . route('admin.orders.destroy', $query->id) . "' class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash'></i></a>";

            return $view . $status . $delete;
        })
        ->addColumn('user_name', function ($query) {
            return $query->user?->name;
        })
        ->addColumn('grand_total', function ($query) {
            return currencyPosition($query->grand_total);
        })
        ->addColumn('created_at', function ($query) {
            return $query->created_at->format('m-d-Y');
        })
        ->addColumn('order_status', function ($query) {

            $orderStatus  = $query->order_status;

            if ($query->order_status === 'delivered') {
                $statusClass = 'badge-success';
            } elseif ($query->order_status === 'declined') {
                $statusClass = 'badge-danger';
            } elseif($query->order_status ==='in_process'){
                $statusClass = 'badge-info';
                $orderStatus = 'In Process';
            }
            else {
                $statusClass = 'badge-warning';
            }
            return "<span class='badge $statusClass'>" . $orderStatus . "</span>";
        })
        ->addColumn('payment_status', function ($query) {
            $statusClass = strtoupper($query->payment_status) == 'COMPLETED' ? 'badge-success' : 'badge-danger';
            return "<span class='badge $statusClass'>" . $query->payment_status . "</span>";
        })
        ->rawColumns(['action', 'user_name', 'grand_total', 'created_at', 'order_status', 'payment_status'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->where('order_status','delivered')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('order-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        //->dom('Bfrtip')
        ->orderBy(0,'desc')
        ->selectStyleSingle()
        ->buttons([
            Button::make('excel'),
            Button::make('csv'),
            Button::make('pdf'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('invoice_id'),
            Column::make('user_name'),
            Column::make('product_qty'),
            Column::make('grand_total'),
            Column::make('order_status'),
            Column::make('payment_status'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DeliveredOrder_' . date('YmdHis');
    }
}
