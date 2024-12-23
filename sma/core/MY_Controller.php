<?php defined('BASEPATH') OR exit('No direct script access allowed');



class MY_Controller extends CI_Controller {



    function __construct()

    {

        parent::__construct();

        define("DEMO", 0);

        $this->Settings = $this->site->get_setting();

        

        if($sma_language = $this->input->cookie('sma_language', TRUE)) {

            $this->Settings->language = $sma_language;

        }



        $this->config->set_item('language', $this->Settings->language);

        $this->lang->load('sma', $this->Settings->language);

        $this->theme = $this->Settings->theme.'/views/';

        if(is_dir(VIEWPATH.$this->Settings->theme.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR)) {

            $this->data['assets'] = base_url() . 'themes/' . $this->Settings->theme . '/assets/';

        } else {

            $this->data['assets'] = base_url() . 'themes/default/assets/';

        }



        $this->data['Settings'] = $this->Settings;

        $this->loggedIn = $this->sma->logged_in();



        if($this->loggedIn) {

            $this->default_currency = $this->site->getCurrencyByCode($this->Settings->default_currency);

            $this->data['default_currency'] = $this->default_currency;

            $this->Owner = $this->sma->in_group('owner') ? TRUE : NULL;

            $this->data['Owner'] = $this->Owner;

            $this->Customer = $this->sma->in_group('customer') ? TRUE : NULL;

            $this->data['Customer'] = $this->Customer;

            $this->Supplier = $this->sma->in_group('supplier') ? TRUE : NULL;

            $this->data['Supplier'] = $this->Supplier;

            $this->Admin = $this->sma->in_group('admin') ? TRUE : NULL;

            $this->data['Admin'] = $this->Admin;



            if($sd = $this->site->getDateFormat($this->Settings->dateformat)) {

                $dateFormats = array(

                    'js_sdate' => $sd->js,

                    'php_sdate' => $sd->php,

                    'mysq_sdate' => $sd->sql,

                    'js_ldate' => $sd->js . ' hh:ii',

                    'php_ldate' => $sd->php . ' H:i',

                    'mysql_ldate' => $sd->sql . ' %H:%i'

                    );

            } else {

                $dateFormats = array(

                    'js_sdate' => 'mm-dd-yyyy',

                    'php_sdate' => 'm-d-Y',

                    'mysq_sdate' => '%m-%d-%Y',

                    'js_ldate' => 'mm-dd-yyyy hh:ii:ss',

                    'php_ldate' => 'm-d-Y H:i:s',

                    'mysql_ldate' => '%m-%d-%Y %T'

                    );

            }

            if(is_dir(VIEWPATH.$this->Settings->theme.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'pos')) {

                define("POS", 1);

            } else {

                define("POS", 0);

            }

            if(!$this->Owner && !$this->Admin) {

                $gp = $this->site->checkPermissions();

                $this->GP = $gp[0];

                $this->data['GP'] = $gp[0];

            } else {

                $this->data['GP'] = NULL;

            }

            $this->dateFormats = $dateFormats;

            $this->data['dateFormats'] = $dateFormats;

            $this->load->language('calendar');

            //$this->default_currency = $this->Settings->currency_code;

            //$this->data['default_currency'] = $this->default_currency;

            $this->m = strtolower($this->router->fetch_class());

            $this->v = strtolower($this->router->fetch_method());

            $this->data['m']= $this->m;

            $this->data['v'] = $this->v;

            $this->data['dt_lang'] = json_encode(lang('datatables_lang'));

            $this->data['dp_lang'] = json_encode(array('days' => array(lang('cal_sunday'), lang('cal_monday'), lang('cal_tuesday'), lang('cal_wednesday'), lang('cal_thursday'), lang('cal_friday'), lang('cal_saturday'), lang('cal_sunday')), 'daysShort' => array(lang('cal_sun'), lang('cal_mon'), lang('cal_tue'), lang('cal_wed'), lang('cal_thu'), lang('cal_fri'), lang('cal_sat'), lang('cal_sun')), 'daysMin' => array(lang('cal_su'), lang('cal_mo'), lang('cal_tu'), lang('cal_we'), lang('cal_th'), lang('cal_fr'), lang('cal_sa'), lang('cal_su')), 'months' => array(lang('cal_january'), lang('cal_february'), lang('cal_march'), lang('cal_april'), lang('cal_may'), lang('cal_june'), lang('cal_july'), lang('cal_august'), lang('cal_september'), lang('cal_october'), lang('cal_november'), lang('cal_december')), 'monthsShort' => array(lang('cal_jan'), lang('cal_feb'), lang('cal_mar'), lang('cal_apr'), lang('cal_may'), lang('cal_jun'), lang('cal_jul'), lang('cal_aug'), lang('cal_sep'), lang('cal_oct'), lang('cal_nov'), lang('cal_dec')), 'today' => lang('today'), 'suffix' => array(), 'meridiem' => array()));



        }

    }



    function page_construct($page, $meta = array(), $data = array()) {

        $meta['message'] = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');

        $meta['error'] = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');

        $meta['warning'] = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');

        $meta['info'] = $this->site->getNotifications();

        $meta['events'] = $this->site->getUpcomingEvents();

        $meta['ip_address'] = $this->input->ip_address();

        $meta['pending_count'] = $this->site->getSalePending();

        $meta['Owner'] = $data['Owner'];

        $meta['Admin'] = $data['Admin'];

        $meta['Supplier'] = $data['Supplier'];

        $meta['Customer'] = $data['Customer'];

        $meta['Settings'] = $data['Settings'];

        $meta['dateFormats'] = $data['dateFormats'];


        $meta['assets'] = $data['assets'];

        $meta['GP'] = $data['GP'];

        $meta['qty_alert_num'] = $this->site->get_total_qty_alerts();

        $meta['exp_alert_num'] = $this->site->get_expiring_qty_alerts();

        $meta['appointment_alert_num'] = $this->site->get_appointment_alerts();

        $this->load->view($this->theme . 'header', $meta);

        $this->load->view($this->theme . $page, $data);

        $this->load->view($this->theme . 'footer');

    }



}

class MY_UserController extends CI_Controller {



    function __construct()

    {

        parent::__construct();

        define("DEMO", 0);

        $this->Settings = $this->site->get_setting();

        

        if($sma_language = $this->input->cookie('sma_language', TRUE)) {

            $this->Settings->language = $sma_language;

        }



        $this->config->set_item('language', $this->Settings->language);

        $this->lang->load('sma', $this->Settings->language);

        $this->theme = $this->Settings->theme.'/views/frontend/';

        if(is_dir(VIEWPATH.$this->Settings->theme.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR)) {

            $this->data['assets'] = base_url() . 'themes/' . $this->Settings->theme . '/assets/';

        } else {

            $this->data['assets'] = base_url() . 'themes/default/assets/';

        }



        $this->data['Settings'] = $this->Settings;

        $this->user_loggedIn = $this->sma->user_logged_in();



        if($this->user_loggedIn) {

            $this->default_currency = $this->site->getCurrencyByCode($this->Settings->default_currency);

            $this->data['default_currency'] = $this->default_currency;

            $this->Owner = NULL;

            $this->data['Owner'] = $this->Owner;

            $this->Customer = NULL;

            $this->data['Customer'] = $this->Customer;

            $this->Supplier = NULL;

            $this->data['Supplier'] = $this->Supplier;

            $this->Admin = NULL;

            $this->data['Admin'] = $this->Admin;



            if($sd = $this->site->getDateFormat($this->Settings->dateformat)) {

                $dateFormats = array(

                    'js_sdate' => $sd->js,

                    'php_sdate' => $sd->php,

                    'mysq_sdate' => $sd->sql,

                    'js_ldate' => $sd->js . ' hh:ii',

                    'php_ldate' => $sd->php . ' H:i',

                    'mysql_ldate' => $sd->sql . ' %H:%i'

                    );

            } else {

                $dateFormats = array(

                    'js_sdate' => 'mm-dd-yyyy',

                    'php_sdate' => 'm-d-Y',

                    'mysq_sdate' => '%m-%d-%Y',

                    'js_ldate' => 'mm-dd-yyyy hh:ii:ss',

                    'php_ldate' => 'm-d-Y H:i:s',

                    'mysql_ldate' => '%m-%d-%Y %T'

                    );

            }

            
            $this->dateFormats = $dateFormats;

            $this->data['dateFormats'] = $dateFormats;

            $this->load->language('calendar');

            //$this->default_currency = $this->Settings->currency_code;

            //$this->data['default_currency'] = $this->default_currency;

            $this->m = strtolower($this->router->fetch_class());

            $this->v = strtolower($this->router->fetch_method());

            $this->data['m']= $this->m;

            $this->data['v'] = $this->v;

            $this->data['GP'] = NULL;

            $this->data['dt_lang'] = json_encode(lang('datatables_lang'));

            $this->data['dp_lang'] = json_encode(array('days' => array(lang('cal_sunday'), lang('cal_monday'), lang('cal_tuesday'), lang('cal_wednesday'), lang('cal_thursday'), lang('cal_friday'), lang('cal_saturday'), lang('cal_sunday')), 'daysShort' => array(lang('cal_sun'), lang('cal_mon'), lang('cal_tue'), lang('cal_wed'), lang('cal_thu'), lang('cal_fri'), lang('cal_sat'), lang('cal_sun')), 'daysMin' => array(lang('cal_su'), lang('cal_mo'), lang('cal_tu'), lang('cal_we'), lang('cal_th'), lang('cal_fr'), lang('cal_sa'), lang('cal_su')), 'months' => array(lang('cal_january'), lang('cal_february'), lang('cal_march'), lang('cal_april'), lang('cal_may'), lang('cal_june'), lang('cal_july'), lang('cal_august'), lang('cal_september'), lang('cal_october'), lang('cal_november'), lang('cal_december')), 'monthsShort' => array(lang('cal_jan'), lang('cal_feb'), lang('cal_mar'), lang('cal_apr'), lang('cal_may'), lang('cal_jun'), lang('cal_jul'), lang('cal_aug'), lang('cal_sep'), lang('cal_oct'), lang('cal_nov'), lang('cal_dec')), 'today' => lang('today'), 'suffix' => array(), 'meridiem' => array()));



        }

    }



    function page_construct($page, $meta = array(), $data = array()) {

        $meta['message'] = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');

        $meta['error'] = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');

        $meta['warning'] = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');

        $meta['info'] = $this->site->getNotifications();

        $meta['events'] = $this->site->getUpcomingEvents();

        $meta['ip_address'] = $this->input->ip_address();

        $meta['Settings'] = $data['Settings'];

        $meta['Owner'] = $data['Owner'];

        $meta['Admin'] = $data['Admin'];

        $meta['Supplier'] = $data['Supplier'];

        $meta['Customer'] = $data['Customer'];

        $meta['dateFormats'] = $data['dateFormats'];

        $meta['assets'] = $data['assets'];

        $meta['GP'] = $data['GP'];

        $meta['qty_alert_num'] = $this->site->get_total_qty_alerts();

        $meta['exp_alert_num'] = $this->site->get_expiring_qty_alerts();

        $meta['appointment_alert_num'] = $this->site->get_appointment_alerts();

        $this->load->view($this->theme . 'header', $meta);

        $this->load->view($this->theme . $page, $data);

        $this->load->view($this->theme . 'footer');

    }



}


