<?php
/**
 * Retrieve the next business day with an optional leadtime.
 * If leadtime = 1 => find the next business day
 * If leadtime = 2 => find the "next next" business day
 * etc...
 *
 * @param int $leadtime
 * @return string|bool
 */
public function getNextBusinessDay($leadtime = 1)
{
    $daterange = $this->_getCalendarDateRange($leadtime);

    // Get weekend days from Magento configuration
    $weekendDays = explode(',', Mage::getStoreConfig('general/locale/weekend'));
    // Sunday is weekday #0 in Magento whereas it is #7 in PHP... update $weekendDays so Sunday is #7
    if (array_search(0, $weekendDays) !== false) {
        $weekendDays[array_search(0, $weekendDays)] = '7';
    }

    $businessDates = array();
    // Build an array containing all business days within our range
    foreach ($daterange as $date) {
        // If current day is not a Magento weekend day, then it is a business day
        if (!in_array($date->format('N'), $weekendDays)) {
            // Populate business days with there formatted values
            // Feel free to update formatting!
            $businessDates[] = Mage::helper('core')->formatDate($date->format('Y-m-d'), 'short', false);
        }
    }

    // If we can find a business day that fits to the required leadtime, return it!
    return (isset($businessDates[$leadtime])) ? $businessDates[$leadtime] : false;
}

/**
 * Retrieve the next calendar day with an optional leadtime.
 * If leadtime = 1 => find the next business day
 * If leadtime = 2 => find the "next next" business day
 * etc...
 *
 * @param int $leadtime
 * @return string|bool
 */
public function getNextCalendarDay($leadtime = 1)
{
    $daterange = $this->_getCalendarDateRange($leadtime);

    $calendarDates = array();
    foreach ($daterange as $date) {
        $calendarDates[] = Mage::helper('core')->formatDate($date->format('Y-m-d'), 'short', false);
    }

    return (isset($calendarDates[$leadtime])) ? $calendarDates[$leadtime] : false;
}

/**
 * Build an array of calendar days
 *
 * @param int $leadtime
 * @return DatePeriod
 */
protected function _getCalendarDateRange($leadtime)
{
    $magentoTime = Mage::getModel('core/date')->timestamp(time());
    // We will search business days starting from today...
    $baseDate = date('Y-m-d H:i:s', $magentoTime);
    $addLeadtime = $leadtime + 7;
    // ... and ending in "$leadtime + one week" in order to make sure to have a complete week of business days
    $targetDate = date('Y-m-d H:i:s', strtotime($baseDate . ' + ' . $addLeadtime . ' days'));

    // Create several Date objects for processing
    $startDate = new DateTime($baseDate);
    $endDate = new DateTime($targetDate);
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($startDate, $interval, $endDate);

    return $daterange;
}
?>
