<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 6/22/16
 * Time: 12:11 AM
 */
namespace App\Libraries\v1;

use App\Libraries\v1\DateHelper;
use Illuminate\Support\Facades\App;
use App\Libraries\v1\Helper;
use Carbon\Carbon;
/**
 * Class ValidationHelper
 * @package App\Libraries\v1
 */
class ValidationHelper
{

    private $validationDateHelper;
    private $helper;

    /**
     * @param DateHelper $validationDateHelper
     * @param Carbon $carbon
     * @param Helper $helper
     */
    public function __construct(DateHelper $validationDateHelper, Carbon $carbon, Helper $helper)
    {
        $this->validationDateHelper = $validationDateHelper;
        $this->carbon = $carbon;
        $this->helper = $helper;
    }

    /**
     * Common validation with models rules
     *
     * @param $inputAll
     * @param $commonRules
     * @return object
     */
    public function validation($inputAll, $commonRules, $messages = [])
    {
        return $validator = \Validator::make($inputAll, $commonRules, $messages);
    }

    /**
     * Check the GET REQUEST parameter passed is set and not empty
     *
     * @param $params
     * @param $key
     * @return bool
     */
    public static function checkQueryArgValid($params, $key)
    {
        return (isset($params[$key]) && $params[$key] != '' && $params[$key] != null) ? true : false;
    }


    /**
     * Check the parameter passed is set and not empty
     *
     * @param $arg
     * @return bool
     */
    public static function isNotEmpty($arg)
    {
        return (isset($arg) && $arg != '' && $arg != null) ? true : false;
    }

    /**
     * Remove script tags from given input
     *
     * @param $value
     * @return mixed
     */
    public function removeScripts($value)
    {
        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $value);
    }

    /**
     * Validate number array
     *
     * @param $array
     * @return bool
     */
    public function validateNumberArray($array)
    {
        foreach ($array as $v) {
            $v = trim($v);
            if (!is_numeric($v)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate user input search filters
     *
     * @param array $searchData
     * @param array $dataMappings
     * @param array $cleanData
     * @return array
     */
    public function validateSearchInputData($searchData = [], $dataMappings = [], $cleanData = [])
    {
        if (empty($searchData['location'])) {
            App::abort(
                $this->helper->getConstants('status-code', 'validation_error_code'),
                trans('search.stylist_search_location_required')
            );
        }
        foreach ($dataMappings as $key => $value) {
            if (!empty($searchData[$key]) && $searchData[$key] != null) {
                if ($value['type'] == 'list') {
                    if (in_array($searchData[$key], $value['list'])) {
                        $cleanData[$key] = $searchData[$key];
                    } else {
                        App::abort(
                            $this->helper->getConstants('status-code', 'validation_error_code'),
                            $value['message']
                        );
                    }
                }
                if ($value['type'] == 'string') {
                    if ($searchData[$key] != '') {
                        $cleanData[$key] = $this->removeScripts($searchData[$key]);

                        if ($key == 'skills') {
                            $skillList = explode(',', $searchData[$key]);
                            if (!$this->validateNumberArray($skillList)) {
                                App::abort(
                                    $this->helper->getConstants('status-code', 'validation_error_code'),
                                    trans('search.stylist_search_invalid_skills')
                                );
                            }
                        }
                    }
                }
                if ($value['type'] == 'date') {
                    if ($this->validationDateHelper->validateDate($searchData[$key])) {
                        $earlyDate = $this->carbon->timezone($this->helper->getConstants('general', 'time_zone'))
                            ->addDay($this->helper->getConstants('general', 'variable_value_two'))
                            ->format($this->helper->getConstants('general', 'default_date_only_format'));
                        if ($searchData[$key] < $earlyDate) {
                            App::abort(
                                $this->helper->getConstants('status-code', 'validation_error_code'),
                                trans('search.stylist_search_valid_date_require')
                            );
                        }
                        $cleanData[$key] = $searchData[$key];
                        $cleanData[$key] = $this->carbon
                            ->timezone($this->helper->getConstants('general', 'time_zone'))
                            ->parse($cleanData[$key])
                            ->format($this->helper->getConstants('general', 'default_date_only_format'));
                    } else {
                        App::abort(
                            $this->helper->getConstants('status-code', 'validation_error_code'),
                            $value['message']
                        );
                    }
                }
                if ($value['type'] == 'integer' && $key == 'no_of_days') {
                    if (!empty($searchData['no_of_days'])) {
                        if ($searchData['no_of_days'] <
                            $this->helper->getConstants('general', 'stylist_search_min_number_of_days') ||
                            $searchData['no_of_days'] >
                            $this->helper->getConstants('general', 'stylist_search_max_number_of_days')
                        ) {
                            App::abort(
                                $this->helper->getConstants('status-code', 'validation_error_code'),
                                trans('search.stylist_search_invalid_number_of_dates_count')
                            );
                        } else {
                            $cleanData[$key] = $searchData[$key];
                        }
                    }
                }
                if ($value['type'] == 'integer' && $key == 'max_rate') {
                    if (!empty($searchData['max_rate'])) {
                        if (!is_numeric($searchData['max_rate']) || $searchData['max_rate'] < 0) {
                            App::abort(
                                $this->helper->getConstants('status-code', 'validation_error_code'),
                                $value['message']
                            );
                        } else {
                            $cleanData[$key] = $searchData[$key];
                        }
                    }
                }
            }
        }
        if ($searchData['business_name'] != null) {
            $cleanData['name'] = $searchData['business_name'];
        }
        return $cleanData;
    }

    /**
     * Check is an integer, if not return default value
     *
     * @param $val
     * @param $default
     * @return mixed
     */
    public function validateNumber($val, $default)
    {
        if (is_numeric($val) && (int)$val == $val && $val >
            $this->helper->getConstants('general', 'variable_value_zero')
        ) {
            return $val;
        } else {
            return $default;
        }
    }

    /**
     * Check is an integer
     *
     * @param $num
     * @return bool
     */
    public function validateInteger($num)
    {
        if (is_numeric($num) && (int)$num == $num && (int)$num >
            $this->helper->getConstants('general', 'variable_value_zero')
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validate rating
     *
     * @param $value
     * @return bool
     */
    public function validateStylistRating($value)
    {
        if (is_numeric($value) &&
            (int)$value >= $this->helper->getConstants('general', 'stylist_min_review_rate') &&
            (int)$value <= $this->helper->getConstants('general', 'stylist_max_review_rate')
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check value is in data list
     *
     * @param $id
     * @param $list
     * @param $key
     * @return bool
     */
    public function validateCheckInList($id, $list, $key)
    {
        $array = array_pluck($list, $key);
        if (in_array($id, $array)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check value is in data list
     *
     * @param $id
     * @param $list
     * @param $key
     * @param $default
     * @return int | string
     */
    public function validateCheckInListAndSendValue($id, $list, $key, $default)
    {
        $array = array_pluck($list, $key);
        return in_array($id, $array) ? $id : $default;
    }

    public function validateArraySize($attribute, $value, $parameters)
    {
        $data = array_get($this->data, $attribute);

        if (!is_array($data)) {
            return true;
        } else {
            $sizeIsOk = count($data) <= $parameters[0];
            return $sizeIsOk;
        }
    }
}
