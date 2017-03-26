<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\DataTable\Filter;

use Piwik\API\DataTableManipulator\Flattener;
use Piwik\DataTable;
use Piwik\DataTable\BaseFilter;

/**
 * Flattens a datatable.
 *
 * **Basic example usage**
 *
 *     $dataTable->filter('Flatten', array());
 *
 * @api
 */
class Flatten extends BaseFilter
{
    /**
     * Constructor.
     *
     * @param DataTable $table The DataTable that will be filtered eventually.
     */
    public function __construct($table, $includeAggregateRows = 0, $recursiveLabelSeparator = ' - ', $apiModule = false, $apiMethod = false, $request = array())
    {
        parent::__construct($table);

        $this->includeAggregateRows = $includeAggregateRows;
        $this->recursiveLabelSeparator  = $recursiveLabelSeparator;
        $this->apiModule = $apiModule;
        $this->apiMethod = $apiMethod;
        $this->request = $request;
    }

    /**
     * See {@link Limit}.
     *
     * @param DataTable $table
     */
    public function filter($table)
    {
        $flattener = new Flattener();
        if ($this->includeAggregateRows) {
            $flattener->includeAggregateRows();
        }

        $newTable = $flattener->flatten($table, $this->recursiveLabelSeparator);

        // replace rows with those of the flattened datatable
        $table->setRows($newTable->getRows());
    }
}
