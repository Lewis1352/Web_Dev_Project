<?php
/**
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 *
 * @package stock-quotes-charts
 */

namespace Coursework;

class CompanyDetailsChartModel
{
    private $output_chart_details;
    private $stored_company_stock_quote_data;
    private $stock_company_symbol;
    private $stock_company_name;
    private $output_chart_path_and_name;

    public function __construct()
    {
        $this->stored_company_stock_quote_data = [];
        $this->output_chart_details = '';
        $this->stock_company_symbol = '';
        $this->stock_company_name = '';
        $this->output_chart_path_and_name = '';
    }

    public function __destruct() {}

    public function setStoredCompanyStockData(array $stored_company_stock_data)
    {
        $this->stored_company_stock_quote_data = $stored_company_stock_data;
    }

    public function createLineChart()
    {
        $this->createChartDetails();
        $this->makeLineChart();
    }

    public function getLineChartDetails()
    {
        return $this->output_chart_details;
    }

    private function createChartDetails()
    {
        $this->stock_company_symbol = $this->stored_company_stock_quote_data['$company_symbol'];
        $this->stock_company_name = $this->stored_company_stock_quote_data['company-name'];
        $output_chart_name = $this->stock_company_symbol . '-linechart-stockdata.png';
        $output_chart_location = LIB_CHART_OUTPUT_PATH;
        $this->output_chart_details = LANDING_PAGE . DIRSEP . $output_chart_location . $output_chart_name;
        $this->output_chart_path_and_name = LIB_CHART_FILE_PATH . $output_chart_location . $output_chart_name;

        if (!is_dir($output_chart_location))
        {
            mkdir($output_chart_location, 0755, true);
        }
    }

    private function makeLineChart()
    {
        $series_data = $this->stored_company_stock_quote_data['company-retrieved-data'];

        $chart = new \LineChart();
        $obj_bound = new \Bound();

        $chart->getPlot()->getPalette()->setLineColor(array(new \Color(255, 130, 0), new \Color(255, 255, 255)));
        $series1 = new \XYDataSet();
        foreach ($series_data as $data_row)
        {
            $index = $data_row['date'];
            $datum = $data_row['value'];
            $series1->addPoint(new \Point($index, $datum));
        }

        $dataSet = new \XYSeriesDataSet();
        $dataSet->addSerie($this->stock_company_symbol, $series1);

        $chart->setDataSet($dataSet);

        $obj_bound->computeBound($dataSet);
        $obj_bound->setLowerBound(12);
        $obj_bound->setUpperBound(14);

        $chart->setTitle($this->stock_company_name);
        $chart->getPlot()->setGraphCaptionRatio(0.75);

        $chart->render($this->output_chart_path_and_name);
    }
}
