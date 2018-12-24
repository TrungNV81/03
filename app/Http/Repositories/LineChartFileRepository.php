<?php

namespace App\Http\Repositories;

use App\Http\Models\LineChartFileModel;

class LineChartFileRepository extends BaseRepository
{
    /**
     * @var LineChartFileModel
     */
    protected $lineChartFileModel;

    /**
     * LineChartFileRepository constructor.
     */
    public function __construct()
    {
        $this->lineChartFileModel = new LineChartFileModel();
    }

    /**
     * @param $dayOfWeek
     * @return mixed
     */
    public function getDay($dayOfWeek)
    {
        return $this->lineChartFileModel->where('day', '=', $dayOfWeek)
            ->get();
    }

    /**
     * @param $value
     * @return mixed
     */
    public function resetLineChartFile($value)
    {
        return $this->lineChartFileModel->where('day', '=', $value)
            ->update(['total' => 0, 'success' => 0, 'fail' => 0]);
    }

    /**
     * @param $dayOfWeek
     * @param $line_chart_file_total
     * @param $category
     * @param $line_chart_file_category
     * @return mixed
     */
    public function updateLineChartFile($dayOfWeek, $line_chart_file_total, $category, $line_chart_file_category)
    {
        return $this->lineChartFileModel->where('day', '=', $dayOfWeek)
            ->update(['total' => $line_chart_file_total, $category => $line_chart_file_category]);
    }

    /**
     * @return mixed
     */
    public function getDataLineChartfile()
    {
        return $this->lineChartFileModel->get();
    }
}
