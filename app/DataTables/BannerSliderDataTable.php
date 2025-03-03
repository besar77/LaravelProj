<?php

namespace App\DataTables;

use App\Models\BannerSlider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BannerSliderDataTable extends DataTable
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
            $edit = "<a href='" . route('admin.bannerSlider.edit', $query->id) . "' class='btn btn-primary'><i class='fas fa-edit'></i></a>";
            $delete = "<a href='" . route('admin.bannerSlider.destroy', $query->id) . "' class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash'></i></a>";

            return $edit . $delete;
        })
            ->addColumn('banner', function($query){
                return '<img width="50px" src="' . asset($query->banner) . '" />';
            })
            ->addColumn('status', function ($query) {
                $statusClass = $query->status == 1 ? 'badge-primary' : 'badge-danger';
                return "<span class='badge $statusClass'>" . ($query->status == 1 ? 'Active' : 'InActive') . "</span>";
            })
            ->rawColumns(['banner', 'action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BannerSlider $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('bannerslider-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
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
            Column::make('banner')->width(200),
            Column::make('title'),
            Column::make('subTitle'),
            Column::make('url'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BannerSlider_' . date('YmdHis');
    }
}