<?php defined('BASEPATH') OR exit('No direct script access allowed');

class system_settings extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('login');
        }

        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect('welcome');
        }
        $this->lang->load('settings', $this->Settings->language);
        $this->load->library('form_validation');
        $this->load->model('settings_model');
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';
    }

    function index()
    {

        $this->form_validation->set_rules('site_name', lang('site_name'), 'trim|required');
        $this->form_validation->set_rules('dateformat', lang('dateformat'), 'trim|required');
        $this->form_validation->set_rules('timezone', lang('timezone'), 'trim|required');
        $this->form_validation->set_rules('mmode', lang('maintenance_mode'), 'trim|required');
        //$this->form_validation->set_rules('logo', lang('logo'), 'trim');
        $this->form_validation->set_rules('iwidth', lang('image_width'), 'trim|numeric|required');
        $this->form_validation->set_rules('iheight', lang('image_height'), 'trim|numeric|required');
        $this->form_validation->set_rules('twidth', lang('thumbnail_width'), 'trim|numeric|required');
        $this->form_validation->set_rules('theight', lang('thumbnail_height'), 'trim|numeric|required');
        $this->form_validation->set_rules('watermark', lang('watermark'), 'trim|required');
        $this->form_validation->set_rules('reg_ver', lang('reg_ver'), 'trim|required');
        $this->form_validation->set_rules('allow_reg', lang('allow_reg'), 'trim|required');
        $this->form_validation->set_rules('reg_notification', lang('reg_notification'), 'trim|required');
        $this->form_validation->set_rules('currency', lang('default_currency'), 'trim|required');
        $this->form_validation->set_rules('email', lang('default_email'), 'trim|required');
        $this->form_validation->set_rules('language', lang('language'), 'trim|required');
        $this->form_validation->set_rules('warehouse', lang('default_warehouse'), 'trim|required');
        $this->form_validation->set_rules('staff', lang('default_staff'), 'trim|required');
        $this->form_validation->set_rules('bank_detail', lang('default_bank_detail'), 'trim|required');
        $this->form_validation->set_rules('biller', lang('default_biller'), 'trim|required');
        $this->form_validation->set_rules('default_bill', lang('default_bill'), 'trim|required');
        $this->form_validation->set_rules('tax_rate', lang('product_tax'), 'trim|required');
        $this->form_validation->set_rules('tax_rate2', lang('invoice_tax'), 'trim|required');
        $this->form_validation->set_rules('sales_prefix', lang('sales_prefix'), 'trim');
        $this->form_validation->set_rules('quote_prefix', lang('quote_prefix'), 'trim');
        $this->form_validation->set_rules('purchase_prefix', lang('purchase_prefix'), 'trim');
        $this->form_validation->set_rules('transfer_prefix', lang('transfer_prefix'), 'trim');
        $this->form_validation->set_rules('delivery_prefix', lang('delivery_prefix'), 'trim');
        $this->form_validation->set_rules('payment_prefix', lang('payment_prefix'), 'trim');
        $this->form_validation->set_rules('return_prefix', lang('return_prefix'), 'trim');
        $this->form_validation->set_rules('expense_prefix', lang('expense_prefix'), 'trim');
        $this->form_validation->set_rules('detect_barcode', lang('detect_barcode'), 'trim|required');
        $this->form_validation->set_rules('theme', lang('theme'), 'trim|required');
        $this->form_validation->set_rules('rows_per_page', lang('rows_per_page'), 'trim|required|greater_than[9]|less_than[501]');
        $this->form_validation->set_rules('accounting_method', lang('accounting_method'), 'trim|required');
        $this->form_validation->set_rules('product_serial', lang('product_serial'), 'trim|required');
        $this->form_validation->set_rules('product_discount', lang('product_discount'), 'trim|required');
        $this->form_validation->set_rules('bc_fix', lang('bc_fix'), 'trim|numeric|required');
        $this->form_validation->set_rules('protocol', lang('email_protocol'), 'trim|required');
        if ($this->input->post('protocol') == 'smtp') {
            $this->form_validation->set_rules('smtp_host', lang('smtp_host'), 'required');
            $this->form_validation->set_rules('smtp_user', lang('smtp_user'), 'required');
            $this->form_validation->set_rules('smtp_pass', lang('smtp_pass'), 'required');
            $this->form_validation->set_rules('smtp_port', lang('smtp_port'), 'required');
        }
        if ($this->input->post('protocol') == 'sendmail') {
            $this->form_validation->set_rules('mailpath', lang('mailpath'), 'required');
        }
        $this->form_validation->set_rules('decimals', lang('decimals'), 'trim|required');
        $this->form_validation->set_rules('decimals_sep', lang('decimals_sep'), 'trim|required');
        $this->form_validation->set_rules('thousands_sep', lang('thousands_sep'), 'trim|required');
        $this->load->library('encrypt');

        if ($this->form_validation->run() == true) {

            $language = $this->input->post('language');

            if ((file_exists('sma/language/' . $language . '/sma_lang.php') && is_dir('sma/language/' . $language)) || $language == 'english') {
                $lang = $language;
            } else {
                $this->session->set_flashdata('error', lang('language_x_found'));
                redirect("system_settings");
                $lang = 'english';
            }

            $tax1 = ($this->input->post('tax_rate') != 0) ? 1 : 0;
            $tax2 = ($this->input->post('tax_rate2') != 0) ? 1 : 0;

            $data = array('site_name' => DEMO ? 'Stock Manager Advance' : $this->input->post('site_name'),
                'rows_per_page' => $this->input->post('rows_per_page'),
                'dateformat' => $this->input->post('dateformat'),
                'timezone' => DEMO ? 'Asia/Kuala_Lumpur' : $this->input->post('timezone'),
                'mmode' => trim($this->input->post('mmode')),
                'iwidth' => $this->input->post('iwidth'),
                'iheight' => $this->input->post('iheight'),
                'twidth' => $this->input->post('twidth'),
                'theight' => $this->input->post('theight'),
                'watermark' => $this->input->post('watermark'),
                'reg_ver' => $this->input->post('reg_ver'),
                'allow_reg' => $this->input->post('allow_reg'),
                'reg_notification' => $this->input->post('reg_notification'),
                'accounting_method' => $this->input->post('accounting_method'),
                'default_email' => DEMO ? 'noreply@sma.tecdiary.my' : $this->input->post('email'),
                'language' => $lang,
                'default_warehouse' => $this->input->post('warehouse'),
                'default_tax_rate' => $this->input->post('tax_rate'),
                'default_tax_rate2' => $this->input->post('tax_rate2'),
                'default_bill' => $this->input->post('default_bill'),
                'sales_prefix' => $this->input->post('sales_prefix'),
                'quote_prefix' => $this->input->post('quote_prefix'),
                'purchase_prefix' => $this->input->post('purchase_prefix'),
                'transfer_prefix' => $this->input->post('transfer_prefix'),
                'delivery_prefix' => $this->input->post('delivery_prefix'),
                'payment_prefix' => $this->input->post('payment_prefix'),
                'return_prefix' => $this->input->post('return_prefix'),
                'expense_prefix' => $this->input->post('expense_prefix'),
                'auto_detect_barcode' => trim($this->input->post('detect_barcode')),
                'theme' => trim($this->input->post('theme')),
                'product_serial' => $this->input->post('product_serial'),
                'customer_group' => $this->input->post('customer_group'),
                'product_expiry' => $this->input->post('product_expiry'),
                'product_discount' => $this->input->post('product_discount'),
                'default_currency' => $this->input->post('currency'),
                'bc_fix' => $this->input->post('bc_fix'),
                'tax1' => $tax1,
                'tax2' => $tax2,
                'overselling' => $this->input->post('restrict_sale'),
                'reference_format' => $this->input->post('reference_format'),
                'racks' => $this->input->post('racks'),
                'attributes' => $this->input->post('attributes'),
                'restrict_calendar' => $this->input->post('restrict_calendar'),
                'captcha' => $this->input->post('captcha'),
                'item_addition' => $this->input->post('item_addition'),
                'protocol' => DEMO ? 'mail' : $this->input->post('protocol'),
                'mailpath' => $this->input->post('mailpath'),
                'smtp_host' => $this->input->post('smtp_host'),
                'smtp_user' => $this->input->post('smtp_user'),
                'smtp_port' => $this->input->post('smtp_port'),
                'smtp_crypto' => $this->input->post('smtp_crypto') ? $this->input->post('smtp_crypto') : NULL,
                'decimals' => $this->input->post('decimals'),
                'decimals_sep' => $this->input->post('decimals_sep'),
                'thousands_sep' => $this->input->post('thousands_sep'),
                'default_biller' => $this->input->post('biller'),
                'default_staff' => $this->input->post('staff'),
                'default_bank_detail' => $this->input->post('bank_detail'),
                'invoice_view' => $this->input->post('invoice_view'),
                'rtl' => $this->input->post('rtl'),
                'each_spent' => $this->input->post('each_spent') ? $this->input->post('each_spent') : NULL,
                'ca_point' => $this->input->post('ca_point') ? $this->input->post('ca_point') : NULL,
                'each_sale' => $this->input->post('each_sale') ? $this->input->post('each_sale') : NULL,
                'sa_point' => $this->input->post('sa_point') ? $this->input->post('sa_point') : NULL,
                'sac' => $this->input->post('sac')
            );
            if ($this->input->post('smtp_pass')) {
                $data['smtp_pass'] = $this->encrypt->encode($this->input->post('smtp_pass'));
            }
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateSetting($data)) {
            if ($this->write_index($data['timezone']) == false) {
                $this->session->set_flashdata('error', lang('setting_updated_timezone_failed'));
                redirect('system_settings');
            }

            $this->session->set_flashdata('message', lang('setting_updated'));
            redirect("system_settings");
        } else {

            $this->data['error'] = validation_errors();
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $this->data['settings'] = $this->settings_model->getSettings();
            $this->data['currencies'] = $this->settings_model->getAllCurrencies();
            $this->data['date_formats'] = $this->settings_model->getDateFormats();
            $this->data['tax_rates'] = $this->settings_model->getAllTaxRates();
            $this->data['staffs'] = $this->site->getAllStaffs();
            $this->data['bank_details'] = $this->site->getAllBankDetail();
            $this->data['customer_groups'] = $this->settings_model->getAllCustomerGroups();
            $this->data['warehouses'] = $this->settings_model->getAllWarehouses();
            $this->data['invoice_types'] = $this->site->getAllInvoiceType();
            $this->data['smtp_pass'] = $this->encrypt->decode($this->data['settings']->smtp_pass);
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('system_settings')));
            $meta = array('page_title' => lang('system_settings'), 'bc' => $bc);
            $this->page_construct('settings/index', $meta, $this->data);
        }
    }

    function paypal()
    {

        $this->form_validation->set_rules('active', $this->lang->line('activate'), 'trim');
        $this->form_validation->set_rules('account_email', $this->lang->line('paypal_account_email'), 'trim|valid_email');
        if ($this->input->post('active')) {
            $this->form_validation->set_rules('account_email', $this->lang->line('paypal_account_email'), 'required');
        }
        $this->form_validation->set_rules('fixed_charges', $this->lang->line('fixed_charges'), 'trim');
        $this->form_validation->set_rules('extra_charges_my', $this->lang->line('extra_charges_my'), 'trim');
        $this->form_validation->set_rules('extra_charges_other', $this->lang->line('extra_charges_others'), 'trim');

        if ($this->form_validation->run() == true) {

            $data = array('active' => $this->input->post('active'),
                'account_email' => $this->input->post('account_email'),
                'fixed_charges' => $this->input->post('fixed_charges'),
                'extra_charges_my' => $this->input->post('extra_charges_my'),
                'extra_charges_other' => $this->input->post('extra_charges_other')
            );
        }

        if ($this->form_validation->run() == true && $this->settings_model->updatePaypal($data)) {
            $this->session->set_flashdata('message', $this->lang->line('paypal_setting_updated'));
            redirect("system_settings/paypal");
        } else {

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->data['paypal'] = $this->settings_model->getPaypalSettings();

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('paypal_settings')));
            $meta = array('page_title' => lang('paypal_settings'), 'bc' => $bc);
            $this->page_construct('settings/paypal', $meta, $this->data);
        }
    }

    function skrill()
    {

        $this->form_validation->set_rules('active', $this->lang->line('activate'), 'trim');
        $this->form_validation->set_rules('account_email', $this->lang->line('paypal_account_email'), 'trim|valid_email');
        if ($this->input->post('active')) {
            $this->form_validation->set_rules('account_email', $this->lang->line('paypal_account_email'), 'required');
        }
        $this->form_validation->set_rules('fixed_charges', $this->lang->line('fixed_charges'), 'trim');
        $this->form_validation->set_rules('extra_charges_my', $this->lang->line('extra_charges_my'), 'trim');
        $this->form_validation->set_rules('extra_charges_other', $this->lang->line('extra_charges_others'), 'trim');

        if ($this->form_validation->run() == true) {

            $data = array('active' => $this->input->post('active'),
                'account_email' => $this->input->post('account_email'),
                'fixed_charges' => $this->input->post('fixed_charges'),
                'extra_charges_my' => $this->input->post('extra_charges_my'),
                'extra_charges_other' => $this->input->post('extra_charges_other')
            );
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateSkrill($data)) {
            $this->session->set_flashdata('message', $this->lang->line('skrill_setting_updated'));
            redirect("system_settings/skrill");
        } else {

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->data['skrill'] = $this->settings_model->getSkrillSettings();

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('skrill_settings')));
            $meta = array('page_title' => lang('skrill_settings'), 'bc' => $bc);
            $this->page_construct('settings/skrill', $meta, $this->data);
        }
    }

    function change_logo()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->load->helper('security');
        $this->form_validation->set_rules('site_logo', lang("site_logo"), 'xss_clean');
        $this->form_validation->set_rules('biller_logo', lang("biller_logo"), 'xss_clean');
        if ($this->form_validation->run() == true) {

            if ($_FILES['site_logo']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path . 'logos/';
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = 300;
                $config['max_height'] = 80;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                //$config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('site_logo')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;

                $this->db->update('settings', array('logo2' => $photo), array('setting_id' => 1));

                $this->session->set_flashdata('message', lang('logo_uploaded'));
                redirect($_SERVER["HTTP_REFERER"]);
            }

            if ($_FILES['biller_logo']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path . 'logos/';
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = 300;
                $config['max_height'] = 80;
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                //$config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('biller_logo')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;

                $this->session->set_flashdata('message', lang('logo_uploaded'));
                redirect($_SERVER["HTTP_REFERER"]);

            }

            $this->session->set_flashdata('error', lang('attempt_failed'));
            redirect($_SERVER["HTTP_REFERER"]);
            die();
        } elseif ($this->input->post('upload_logo')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/change_logo', $this->data);
        }
    }

    public function write_index($timezone)
    {

        $template_path = './assets/config_dumps/index.php';
        $output_path = SELF;
        $index_file = file_get_contents($template_path);
        $new = str_replace("%TIMEZONE%", $timezone, $index_file);
        $handle = fopen($output_path, 'w+');
        @chmod($output_path, 0777);

        if (is_writable($output_path)) {
            if (fwrite($handle, $new)) {
                @chmod($output_path, 0644);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function updates()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->form_validation->set_rules('purchase_code', lang("purchase_code"), 'required');
        $this->form_validation->set_rules('envato_username', lang("envato_username"), 'required');
        if ($this->form_validation->run() == true) {
            $this->db->update('settings', array('purchase_code' => $this->input->post('purchase_code', TRUE), 'envato_username' => $this->input->post('envato_username', TRUE)), array('setting_id' => 1));
            redirect('system_settings/updates');
        } else {
            $fields = array('version' => $this->Settings->version, 'code' => $this->Settings->purchase_code, 'username' => $this->Settings->envato_username, 'site' => base_url());
            $this->load->helper('update');
            $protocol = is_https() ? 'https://' : 'http://';
            $updates = get_remote_contents($protocol.'tecdiary.com/api/v1/update/', $fields);
            $this->data['updates'] = json_decode($updates);
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('updates')));
            $meta = array('page_title' => lang('updates'), 'bc' => $bc);
            $this->page_construct('settings/updates', $meta, $this->data);
        }
    }

    function install_update($file, $m_version, $version)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->helper('update');
        save_remote_file($file . '.zip');
        $this->sma->unzip('./files/updates/' . $file . '.zip');
        if ($m_version) {
            $this->load->library('migration');
            if (!$this->migration->latest()) {
                $this->session->set_flashdata('error', $this->migration->error_string());
                redirect("system_settings/updates");
            }
        }
        $this->db->update('settings', array('version' => $version, 'update' => 0), array('setting_id' => 1));
        unlink('./files/updates/' . $file . '.zip');
        $this->session->set_flashdata('success', lang('update_done'));
        redirect("system_settings/updates");
    }

    function backups()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->data['files'] = glob('./files/backups/*.zip', GLOB_BRACE);
        $this->data['dbs'] = glob('./files/backups/*.txt', GLOB_BRACE);
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('backups')));
        $meta = array('page_title' => lang('backups'), 'bc' => $bc);
        $this->page_construct('settings/backups', $meta, $this->data);
    }

    function backup_database()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->dbutil();
        $prefs = array(
            'format' => 'txt',
            'filename' => 'sma_db_backup.sql'
        );
        $back = $this->dbutil->backup($prefs);
        $backup =& $back;
        $db_name = 'db-backup-on-' . date("Y-m-d-H-i-s") . '.txt';
        $save = './files/backups/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        $this->session->set_flashdata('messgae', lang('db_saved'));
        redirect("system_settings/backups");
    }

    function backup_files()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $name = 'file-backup-' . date("Y-m-d-H-i-s");
        $this->sma->zip("./", './files/backups/', $name);
        $this->session->set_flashdata('messgae', lang('backup_saved'));
        redirect("system_settings/backups");
        exit();
    }

    function restore_database($dbfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $file = file_get_contents('./files/backups/' . $dbfile . '.txt');
        $this->db->conn_id->multi_query($file);
        $this->db->conn_id->close();
        redirect('logout/db');
    }

    function download_database($dbfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->library('zip');
        $this->zip->read_file('./files/backups/' . $dbfile . '.txt');
        $name = 'db_backup_' . date('Y_m_d_H_i_s') . '.zip';
        $this->zip->download($name);
        exit();
    }

    function download_backup($zipfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->helper('download');
        force_download('./files/backups/' . $zipfile . '.zip', NULL);
        exit();
    }

    function restore_backup($zipfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $file = './files/backups/' . $zipfile . '.zip';
        $this->sma->unzip($file, './');
        $this->session->set_flashdata('success', lang('files_restored'));
        redirect("system_settings/backups");
        exit();
    }

    function delete_database($dbfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        unlink('./files/backups/' . $dbfile . '.txt');
        $this->session->set_flashdata('messgae', lang('db_deleted'));
        redirect("system_settings/backups");
    }

    function delete_backup($zipfile)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        unlink('./files/backups/' . $zipfile . '.zip');
        $this->session->set_flashdata('messgae', lang('backup_deleted'));
        redirect("system_settings/backups");
    }

    function email_templates($template = "credentials")
    {

        $this->form_validation->set_rules('mail_body', lang('mail_message'), 'trim|required');
        $this->load->helper('file');
        $temp_path = is_dir('./themes/' . $this->theme . '/views/email_templates/');
        $theme = $temp_path ? $this->theme : 'default';
        if ($this->form_validation->run() == true) {
            $data = $_POST["mail_body"];
            if (write_file('./themes/' . $theme . '/views/email_templates/' . $template . '.html', $data)) {
                $this->session->set_flashdata('message', lang('message_successfully_saved'));
                redirect('system_settings/email_templates#' . $template);
            } else {
                $this->session->set_flashdata('error', lang('failed_to_save_message'));
                redirect('system_settings/email_templates#' . $template);
            }
        } else {

            $this->data['credentials'] = file_get_contents('./themes/' . $theme . '/views/email_templates/credentials.html');
            $this->data['sale'] = file_get_contents('./themes/' . $theme . '/views/email_templates/sale.html');
            $this->data['quote'] = file_get_contents('./themes/' . $theme . '/views/email_templates/quote.html');
            $this->data['purchase'] = file_get_contents('./themes/' . $theme . '/views/email_templates/purchase.html');
            $this->data['transfer'] = file_get_contents('./themes/' . $theme . '/views/email_templates/transfer.html');
            $this->data['payment'] = file_get_contents('./themes/' . $theme . '/views/email_templates/payment.html');
            $this->data['forgot_password'] = file_get_contents('./themes/' . $theme . '/views/email_templates/forgot_password.html');
            $this->data['activate_email'] = file_get_contents('./themes/' . $theme . '/views/email_templates/activate_email.html');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('email_templates')));
            $meta = array('page_title' => lang('email_templates'), 'bc' => $bc);
            $this->page_construct('settings/email_templates', $meta, $this->data);
        }
    }

    function create_group()
    {

        $this->form_validation->set_rules('group_name', lang('group_name'), 'required|alpha_dash');
        //$this->form_validation->set_rules('description', lang('group_description'), 'xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $data = array('name' => strtolower($this->input->post('group_name')), 'description' => $this->input->post('description'));
            $new_group_id = $this->settings_model->addGroup($data);
            if ($new_group_id) {
                $this->session->set_flashdata('message', lang('group_added'));
                redirect("system_settings/permissions/" . $new_group_id);
            }
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('description'),
            );
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/create_group', $this->data);
        }
    }

    function edit_group($id)
    {

        if (!$id || empty($id)) {
            redirect('system_settings/user_groups');
        }

        $group = $this->settings_model->getGroupByID($id);

        $this->form_validation->set_rules('group_name', lang('group_name'), 'required|alpha_dash');

        if ($this->form_validation->run() === TRUE) {
            $data = array('name' => strtolower($this->input->post('group_name')), 'description' => $this->input->post('description'));
            $group_update = $this->settings_model->updateGroup($id, $data);

            if ($group_update) {
                $this->session->set_flashdata('message', lang('group_udpated'));
            } else {
                $this->session->set_flashdata('error', lang('attempt_failed'));
            }
            redirect("system_settings/user_groups");
        } else {


            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['group'] = $group;

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('group_name', $group->name),
            );
            $this->data['group_description'] = array(
                'name' => 'group_description',
                'id' => 'group_description',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('group_description', $group->description),
            );
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/edit_group', $this->data);
        }
    }

    function permissions($id = NULL)
    {

        $this->form_validation->set_rules('group', lang("group"), 'is_natural_no_zero');
        if ($this->form_validation->run() == true) {

            $data = array(
                'products-index' => $this->input->post('products-index'),
                'products-edit' => $this->input->post('products-edit'),
                'products-add' => $this->input->post('products-add'),
                'products-delete' => $this->input->post('products-delete'),
                'products-cost' => $this->input->post('products-cost'),
                'products-price' => $this->input->post('products-price'),
                'customers-index' => $this->input->post('customers-index'),
                'customers-edit' => $this->input->post('customers-edit'),
                'customers-add' => $this->input->post('customers-add'),
                'customers-delete' => $this->input->post('customers-delete'),
                'suppliers-index' => $this->input->post('suppliers-index'),
                'suppliers-edit' => $this->input->post('suppliers-edit'),
                'suppliers-add' => $this->input->post('suppliers-add'),
                'suppliers-delete' => $this->input->post('suppliers-delete'),
                'staffs-index' => $this->input->post('staffs-index'),
                'staffs-edit' => $this->input->post('staffs-edit'),
                'staffs-add' => $this->input->post('staffs-add'),
                'staffs-delete' => $this->input->post('staffs-delete'),
                'sales-index' => $this->input->post('sales-index'),
                'sales-edit' => $this->input->post('sales-edit'),
                'sales-add' => $this->input->post('sales-add'),
                'sales-delete' => $this->input->post('sales-delete'),
                'sales-email' => $this->input->post('sales-email'),
                'sales-pdf' => $this->input->post('sales-pdf'),
                'sales-deliveries' => $this->input->post('sales-deliveries'),
                'sales-edit_delivery' => $this->input->post('sales-edit_delivery'),
                'sales-add_delivery' => $this->input->post('sales-add_delivery'),
                'sales-delete_delivery' => $this->input->post('sales-delete_delivery'),
                'sales-email_delivery' => $this->input->post('sales-email_delivery'),
                'sales-pdf_delivery' => $this->input->post('sales-pdf_delivery'),
                'sales-gift_cards' => $this->input->post('sales-gift_cards'),
                'sales-edit_gift_card' => $this->input->post('sales-edit_gift_card'),
                'sales-add_gift_card' => $this->input->post('sales-add_gift_card'),
                'sales-delete_gift_card' => $this->input->post('sales-delete_gift_card'),
                'quotes-index' => $this->input->post('quotes-index'),
                'quotes-edit' => $this->input->post('quotes-edit'),
                'quotes-add' => $this->input->post('quotes-add'),
                'quotes-delete' => $this->input->post('quotes-delete'),
                'quotes-email' => $this->input->post('quotes-email'),
                'quotes-pdf' => $this->input->post('quotes-pdf'),
                'purchases-index' => $this->input->post('purchases-index'),
                'purchases-edit' => $this->input->post('purchases-edit'),
                'purchases-add' => $this->input->post('purchases-add'),
                'purchases-delete' => $this->input->post('purchases-delete'),
                'purchases-email' => $this->input->post('purchases-email'),
                'purchases-pdf' => $this->input->post('purchases-pdf'),
                'transfers-index' => $this->input->post('transfers-index'),
                'transfers-edit' => $this->input->post('transfers-edit'),
                'transfers-add' => $this->input->post('transfers-add'),
                'transfers-delete' => $this->input->post('transfers-delete'),
                'transfers-email' => $this->input->post('transfers-email'),
                'transfers-pdf' => $this->input->post('transfers-pdf'),
                'sales-return_sales' => $this->input->post('sales-return_sales'),
                'reports-quantity_alerts' => $this->input->post('reports-quantity_alerts'),
                'reports-expiry_alerts' => $this->input->post('reports-expiry_alerts'),
                'reports-products' => $this->input->post('reports-products'),
                'reports-daily_sales' => $this->input->post('reports-daily_sales'),
                'reports-monthly_sales' => $this->input->post('reports-monthly_sales'),
                'reports-payments' => $this->input->post('reports-payments'),
                'reports-purchases' => $this->input->post('reports-purchases'),
                'reports-customers' => $this->input->post('reports-customers'),
                'reports-suppliers' => $this->input->post('reports-suppliers'),
                'reports-staffs' => $this->input->post('reports-staffs'),
                'sales-payments' => $this->input->post('sales-payments'),
                'purchases-payments' => $this->input->post('purchases-payments'),
                'purchases-expenses' => $this->input->post('purchases-expenses'),
            );

            if (POS) {
                $data['pos-index'] = $this->input->post('pos-index');
            }

            //$this->sma->print_arrays($data);
        }


        if ($this->form_validation->run() == true && $this->settings_model->updatePermissions($id, $data)) {
            $this->session->set_flashdata('message', lang("group_permissions_updated"));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->data['id'] = $id;
            $this->data['p'] = $this->settings_model->getGroupPermissions($id);
            $this->data['group'] = $this->settings_model->getGroupByID($id);

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('group_permissions')));
            $meta = array('page_title' => lang('group_permissions'), 'bc' => $bc);
            $this->page_construct('settings/permissions', $meta, $this->data);
        }
    }

    function user_groups()
    {

        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('auth');
        }

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        $this->data['groups'] = $this->settings_model->getGroups();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('groups')));
        $meta = array('page_title' => lang('groups'), 'bc' => $bc);
        $this->page_construct('settings/user_groups', $meta, $this->data);
    }

    function delete_group($id = NULL)
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang("access_denied"));
            redirect('welcome', 'refresh');
        }

        if ($this->settings_model->checkGroupUsers($id)) {
            $this->session->set_flashdata('error', lang("group_x_b_deleted"));
            redirect("system_settings/user_groups");
        }

        if ($this->settings_model->deleteGroup($id)) {
            $this->session->set_flashdata('message', lang("group_deleted"));
            redirect("system_settings/user_groups");
        }
    }

    function discounts()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $this->data['customer_groups'] = ["NON MEMBER", "MEMBER"];
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('discounts')));
        $meta = array('page_title' => lang('Discounts'), 'bc' => $bc);
        $this->page_construct('settings/discounts', $meta, $this->data);
    }

    function getDiscounts()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name, value, price_for_value, start_date, end_date,
                    CASE 
                        WHEN customer_group_id = 4 THEN 'MEMBER'
                        ELSE 'NON MEMBER'
                    END AS customer_group_name,
                    created_on")
            ->from("sma_discounts")
            ->add_column("Actions", "<center>
                <a href='" . site_url('system_settings/edit_discount/$1') . "' class='tip' title='" . lang("edit_discount") . "' data-toggle='modal' data-target='#myModal'>
                    <i class=\"fa fa-edit\"></i>
                </a> 
                <a href='#' class='tip po' title='<b>" . lang("delete_discount") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p>
                    <a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_discount/$1') . "'>" . lang('i_m_sure') . "</a> 
                    <button class='btn po-close'>" . lang('no') . "</button>\" rel='popover'>
                    <i class=\"fa fa-trash-o\"></i>
                </a>
            </center>", "id");

        echo $this->datatables->generate();
    }

    function add_discount() {
        $this->form_validation->set_rules('name', lang("name"), 'trim|is_unique[discounts.name]|required');
        $this->form_validation->set_rules('price_for_value', lang("price_for_value"), 'required|numeric');
        $this->form_validation->set_rules('value', lang("value"), 'required|numeric');
        $this->form_validation->set_rules('start_date', lang("start_date"), 'required|callback_validate_date');
        $this->form_validation->set_rules('end_date', lang("end_date"), 'required|callback_validate_date');
        $this->form_validation->set_rules('customer_group', lang("customer_group"), 'required');
        if ($this->form_validation->run() == true) {
            $data = array(
                'name'        => $this->input->post('name'),
                'price_for_value'       => $this->input->post('price_for_value'),
                'value'       => $this->input->post('value'),
                'start_date'       =>$this->reformat_date($this->input->post('start_date')),
                'end_date'  => $this->reformat_date($this->input->post('end_date')),
                'customer_group_id'  => $this->input->post('customer_group'),
            );
        } elseif ($this->input->post('add_discount')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/discounts");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addDiscount($data)) {
            $this->session->set_flashdata('message', lang("Discount_Added"));
            redirect("system_settings/discounts");
        } else {
            $this->data['customer_groups'] = array(4 => "NON MEMBER", 5=>"MEMBER");
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['page_title'] = lang("new_discount");
            $this->load->view($this->theme . 'settings/add_discount', $this->data);
        }
    }

    function edit_discount($id = NULL)
    {
        $discount = $this->settings_model->getDiscountByID($id);
        $this->form_validation->set_rules('name', lang("name"), 'trim|required');
        $this->form_validation->set_rules('price_for_value', lang("price_for_value"), 'required|numeric');
        $this->form_validation->set_rules('value', lang("value"), 'required|numeric');
        $this->form_validation->set_rules('start_date', lang("start_date"), 'required|callback_validate_date');
        $this->form_validation->set_rules('end_date', lang("end_date"), 'required|callback_validate_date');
        $this->form_validation->set_rules('customer_group', lang("customer_group"), 'required');
        if ($this->form_validation->run() == true) {
            $data = array(
                'name'        => $this->input->post('name'),
                'price_for_value'       => $this->input->post('price_for_value'),
                'value'       => $this->input->post('value'),
                'start_date'       =>$this->reformat_date($this->input->post('start_date')),
                'end_date'  => $this->reformat_date($this->input->post('end_date')),
                'customer_group_id'  => $this->input->post('customer_group'),
            );
        } elseif ($this->input->post('edit_discount')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/discounts");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateDiscount($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("discount_updated"));
            redirect("system_settings/discounts");
        } else {
            $this->data['customer_groups'] = array(4 => "NON MEMBER", 5=>"MEMBER");
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['discount'] = $discount;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/edit_discount', $this->data);
        }
    }

    function delete_discount($id = NULL)
    {
        if ($this->settings_model->deleteDiscount($id)) {
            echo lang("Discount_Deleted");
        }
    }

    function discount_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteDiscount($id);
                    }
                    $this->session->set_flashdata('message', lang("Discount_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('coupons'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('value'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('price_for_value'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer_group'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('start_date'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('end_date'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('Created'));


                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->settings_model->getDiscountByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->name);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->value);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->price_for_value);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sc->customer_group_id);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sc->start_date);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sc->end_date);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $sc->created_on);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'discount_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("No_Discounts_Selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
    

    function coupons()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('coupons')));
        $meta = array('page_title' => lang('coupons'), 'bc' => $bc);
        $this->page_construct('settings/coupons', $meta, $this->data);
    }

    function getCoupons()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name, price, value, count, start_date, expiry_date, valid_upto")
            ->from("coupons")
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_coupon/$1') . "' class='tip' title='" . lang("edit_coupon") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_coupon") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_coupon/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function coupon_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteCoupon($id);
                    }
                    $this->session->set_flashdata('message', lang("coupons_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('coupons'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('price'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('value'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('count'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('start_date'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('expiry_date'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('Valid_Upto'));


                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->settings_model->getCouponByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->name);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->price);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->value);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sc->count);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sc->start_date);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sc->expiry_date);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $sc->valid_upto);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'coupons_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_coupons_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function validate_date($date)
    {
        try {
            // Attempt to parse the date into a standard format (YYYY-MM-DD)
            $formattedDate = DateTime::createFromFormat('Y-m-d', $date) 
                            ?: DateTime::createFromFormat('d/m/Y', $date) 
                            ?: DateTime::createFromFormat('m-d-Y', $date);
            
            if ($formattedDate) {
                // Reformat to 'YYYY-MM-DD' for consistency
                $formattedDateString = $formattedDate->format('Y-m-d');

                // Validate the reformatted date using 'checkdate'
                list($year, $month, $day) = explode('-', $formattedDateString);
                if (checkdate($month, $day, $year)) {
                    return true; // Valid date
                }
            }

            // Set an error message if the date is invalid
            $this->form_validation->set_message('validate_date', lang("The {field} is not a valid date."));
            return false;
        } catch (Exception $e) {
            // Handle unexpected exceptions (e.g., invalid formats)
            $this->form_validation->set_message('validate_date', lang("The {field} must be in a valid date format."));
            return false;
        }
    }



    function add_coupons() {
        $this->form_validation->set_rules('name', lang("name"), 'trim|is_unique[coupons.name]|required');
        $this->form_validation->set_rules('price', lang("price"), 'required|numeric');
        $this->form_validation->set_rules('value', lang("value"), 'required|numeric');
        $this->form_validation->set_rules('count', lang("count"), 'required|numeric');
        $this->form_validation->set_rules('start_date', lang("start_date"), 'required|callback_validate_date');
        $this->form_validation->set_rules('expiry_date', lang("expiry_date"), 'required|callback_validate_date');

        if ($this->form_validation->run() == true) {
            $data = array(
                'name'        => $this->input->post('name'),
                'price'       => $this->input->post('price'),
                'value'       => $this->input->post('value'),
                'count'       => $this->input->post('count'),
                'start_date'  => $this->reformat_date($this->input->post('start_date')),
                'expiry_date' => $this->reformat_date($this->input->post('expiry_date')),
                'valid_upto'  => $this->reformat_date($this->input->post('validity')),
            );
        } elseif ($this->input->post('add_coupon')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/coupons");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addCoupon($data)) {
            $this->session->set_flashdata('message', lang("coupon_added"));
            redirect("system_settings/coupons");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['page_title'] = lang("new_coupon");
            $this->load->view($this->theme . 'settings/add_coupons', $this->data);
        }
    }

    function edit_coupon($id = NULL)
    {
        $coupon = $this->settings_model->getCouponByID($id);
        $this->form_validation->set_rules('name', lang("name"), 'required');
        $this->form_validation->set_rules('price', lang("price"), 'required|numeric');
        $this->form_validation->set_rules('value', lang("value"), 'required|numeric');
        $this->form_validation->set_rules('count', lang("count"), 'required|numeric');
        $this->form_validation->set_rules('start_date', lang("start_date"), 'required|callback_validate_date');
        $this->form_validation->set_rules('expiry_date', lang("expiry_date"), 'required|callback_validate_date');

        if ($this->form_validation->run() == true) {

            $data = array(
                'name'        => $this->input->post('name'),
                'price'       => $this->input->post('price'),
                'value'       => $this->input->post('value'),
                'count'       => $this->input->post('count'),
                'start_date'  => $this->reformat_date($this->input->post('start_date')),
                'expiry_date' => $this->reformat_date($this->input->post('expiry_date')),
                'valid_upto'  => $this->reformat_date($this->input->post('validity')),
            );
        } elseif ($this->input->post('edit_coupon')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/coupons");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateCoupon($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("coupon_updated"));
            redirect("system_settings/coupons");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['coupon'] = $coupon;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/edit_coupon', $this->data);
        }
    }

    function delete_coupon($id = NULL)
    {

        if ($this->settings_model->deleteCoupon($id)) {
            echo lang("coupon_deleted");
        }
    }

    private function reformat_date($date)
    {
        $formattedDate = DateTime::createFromFormat('Y-m-d', $date) 
                        ?: DateTime::createFromFormat('d/m/Y', $date) 
                        ?: DateTime::createFromFormat('m-d-Y', $date);

        return $formattedDate ? $formattedDate->format('Y-m-d') : null;
    }

    function currencies()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('currencies')));
        $meta = array('page_title' => lang('currencies'), 'bc' => $bc);
        $this->page_construct('settings/currencies', $meta, $this->data);
    }

    function getCurrencies()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, code, name, rate")
            ->from("currencies")
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_currency/$1') . "' class='tip' title='" . lang("edit_currency") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_currency") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_currency/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }  

    function add_currency()
    {

        $this->form_validation->set_rules('code', lang("currency_code"), 'trim|is_unique[currencies.code]|required');
        $this->form_validation->set_rules('name', lang("name"), 'required');
        $this->form_validation->set_rules('rate', lang("exchange_rate"), 'required|numeric');

        if ($this->form_validation->run() == true) {
            $data = array('code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'rate' => $this->input->post('rate'),
            );
        } elseif ($this->input->post('add_currency')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/currencies");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addCurrency($data)) { //check to see if we are creating the customer
            $this->session->set_flashdata('message', lang("currency_added"));
            redirect("system_settings/currencies");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['page_title'] = lang("new_currency");
            $this->load->view($this->theme . 'settings/add_currency', $this->data);
        }
    }

    function edit_currency($id = NULL)
    {

        $this->form_validation->set_rules('code', lang("currency_code"), 'trim|required');
        $cur_details = $this->settings_model->getCurrencyByID($id);
        if ($this->input->post('code') != $cur_details->code) {
            $this->form_validation->set_rules('code', lang("currency_code"), 'is_unique[currencies.code]');
        }
        $this->form_validation->set_rules('name', lang("currency_name"), 'required');
        $this->form_validation->set_rules('rate', lang("exchange_rate"), 'required|numeric');

        if ($this->form_validation->run() == true) {

            $data = array('code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'rate' => $this->input->post('rate'),
            );
        } elseif ($this->input->post('edit_currency')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/currencies");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateCurrency($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("currency_updated"));
            redirect("system_settings/currencies");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['currency'] = $this->settings_model->getCurrencyByID($id);
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/edit_currency', $this->data);
        }
    }

    function delete_currency($id = NULL)
    {

        if ($this->settings_model->deleteCurrency($id)) {
            echo lang("currency_deleted");
        }
    }

    function currency_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteCurrency($id);
                    }
                    $this->session->set_flashdata('message', lang("currencies_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('currencies'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('code'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('rate'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->settings_model->getCurrencyByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->code);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->name);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->rate);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'currencies_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_tax_rate_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function categories()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('categories')));
        $meta = array('page_title' => lang('categories'), 'bc' => $bc);
        $this->page_construct('settings/categories', $meta, $this->data);
    }

    function getCategories()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, image, code, name")
            ->from("categories")
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/subcategories/$1') . "' class='tip' title='" . lang("list_subcategories") . "'><i class=\"fa fa-list\"></i></a> <a href='" . site_url('system_settings/edit_category/$1') . "' data-toggle='modal' data-target='#myModal' class='tip' title='" . lang("edit_category") . "'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_category") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_category/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");

        echo $this->datatables->generate();
    }

    function add_category()
    {

        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("category_code"), 'trim|is_unique[categories.code]|required');
        $this->form_validation->set_rules('name', lang("name"), 'required|min_length[3]');
        $this->form_validation->set_rules('userfile', lang("category_image"), 'xss_clean');
        $this->form_validation->set_rules('item_type', lang("item_type"), 'required');
            
        if ($this->form_validation->run() == true) {
            $name = $this->input->post('name');
            $code = $this->input->post('code');
            $item_type = $this->input->post('item_type');
    
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->Settings->iwidth;
                $config['max_height'] = $this->Settings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                //$data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->Settings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'right';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            } else {
                $photo = NULL;
            }
        } elseif ($this->input->post('add_category')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/categories");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addCategory($name, $code, $item_type, $photo)) {
            $this->session->set_flashdata('message', lang("category_added"));
            redirect("system_settings/categories");
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

            $this->data['name'] = array('name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['code'] = array('name' => 'code',
                'id' => 'code',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('code'),
            );
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/add_category', $this->data);
        }
    }

    function edit_category($id = NULL)
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("category_code"), 'trim|required');
        $pr_details = $this->settings_model->getCategoryByID($id);
        if ($this->input->post('code') != $pr_details->code) {
            $this->form_validation->set_rules('code', lang("category_code"), 'is_unique[categories.code]');
        }
        $this->form_validation->set_rules('name', lang("category_name"), 'required|min_length[3]');
        $this->form_validation->set_rules('item_type', lang("item_type"), 'required');
        $this->form_validation->set_rules('userfile', lang("category_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            $data = array('code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'item_type' => $this->input->post('item_type')
            );
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->Settings->iwidth;
                $config['max_height'] = $this->Settings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                //$data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->Settings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'right';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            } else {
                $photo = NULL;
            }
        } elseif ($this->input->post('edit_category')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/categories");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateCategory($id, $data, $photo)) {
            $this->session->set_flashdata('message', lang("category_updated"));
            redirect("system_settings/categories");
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $category = $this->settings_model->getCategoryByID($id);
            $this->data['category'] = $this->settings_model->getCategoryByID($id);
            $this->data['name'] = array('name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('name', $category->name),
            );
            $this->data['code'] = array('name' => 'code',
                'id' => 'code',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('code', $category->code),
            );

            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/edit_category', $this->data);
        }
    }

    function delete_category($id = NULL)
    {

        if ($this->settings_model->getSubCategoriesByCategoryID($id)) {
            $this->session->set_flashdata('error', lang("category_has_subcategory"));
            redirect("categories", 'refresh');
        }

        if ($this->settings_model->deleteCategory($id)) {
            echo lang("category_deleted");
        }
    }

    function category_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteCategory($id);
                    }
                    $this->session->set_flashdata('message', lang("categories_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('categories'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('code'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->settings_model->getCategoryByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->code);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->name);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'categories_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_tax_rate_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function subcategories($parent_id = NULL)
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $this->data['parent_id'] = $parent_id;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => site_url('system_settings/categories'), 'page' => lang('categories')), array('link' => '#', 'page' => lang('subcategories')));
        $meta = array('page_title' => lang('subcategories'), 'bc' => $bc);
        $this->page_construct('settings/subcategories', $meta, $this->data);
    }

    function getSubcategories($parent_id = NULL)
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('subcategories').".id as id, ".$this->db->dbprefix('subcategories').".image as image, ".$this->db->dbprefix('subcategories').".code as scode, ".$this->db->dbprefix('subcategories').".name as sname, ".$this->db->dbprefix('categories').".name as cname", false)
            ->from("subcategories")
            ->join('categories', 'categories.id = subcategories.category_id', 'left')
            ->group_by('subcategories.id');

        if ($parent_id) {
            $this->datatables->where($this->db->dbprefix('subcategories').".category_id", $parent_id);
        }

        $this->datatables->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_subcategory/$1') . "' data-toggle='modal' data-target='#myModal' class='tip' title='" . lang("edit_subcategory") . "'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_subcategory") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_subcategory/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
        // ->unset_column('id');
        echo $this->datatables->generate();
    }

    function add_subcategory($parent_id = NULL)
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('category', lang("main_category"), 'required');
        $this->form_validation->set_rules('code', lang("subcategory_code"), 'trim|is_unique[categories.code]|is_unique[subcategories.code]|required');
        $this->form_validation->set_rules('name', lang("subcategory_name"), 'required|min_length[2]');
        $this->form_validation->set_rules('userfile', lang("category_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            $name = $this->input->post('name');
            $code = $this->input->post('code');
            $category = $this->input->post('category');
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->Settings->iwidth;
                $config['max_height'] = $this->Settings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                //$data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->Settings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'right';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            } else {
                $photo = NULL;
            }
        } elseif ($this->input->post('add_subcategory')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/subcategories");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addSubCategory($category, $name, $code, $photo)) {
            $this->session->set_flashdata('message', lang("subcategory_added"));
            redirect("system_settings/subcategories", 'refresh');
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

            $this->data['name'] = array('name' => 'name',
                'id' => 'name',
                'type' => 'text', 'class' => 'form-control',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['code'] = array('name' => 'code',
                'id' => 'code',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('code'),
            );
            $this->data['parent_id'] = $parent_id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['categories'] = $this->settings_model->getAllCategories();
            $this->load->view($this->theme . 'settings/add_subcategory', $this->data);
        }
    }

    function edit_subcategory($id = NULL)
    {

        $this->load->helper('security');
        $this->form_validation->set_rules('category', lang("main_category"), 'required');
        $this->form_validation->set_rules('code', lang("subcategory_code"), 'trim|required');
        $pr_details = $this->settings_model->getSubCategoryByID($id);
        if ($this->input->post('code') != $pr_details->code) {
            $this->form_validation->set_rules('code', lang("subcategory_code"), 'is_unique[categories.code]');
        }
        $this->form_validation->set_rules('name', lang("subcategory_name"), 'required|min_length[2]');
        $this->form_validation->set_rules('userfile', lang("category_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            $data = array(
                'category' => $this->input->post('category'),
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name')
            );
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->Settings->iwidth;
                $config['max_height'] = $this->Settings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                //$data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->Settings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'right';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            } else {
                $photo = NULL;
            }
        } elseif ($this->input->post('edit_subcategory')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/subcategories");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateSubCategory($id, $data, $photo)) {
            $this->session->set_flashdata('message', lang("subcategory_updated"));
            redirect("system_settings/subcategories");
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['subcategory'] = $this->settings_model->getSubCategoryByID($id);
            $this->data['categories'] = $this->settings_model->getAllCategories();
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/edit_subcategory', $this->data);
        }
    }

    function delete_subcategory($id = NULL)
    {

        if ($this->settings_model->deleteSubCategory($id)) {
            echo lang("subcategory_deleted");
        }
    }

    function subcategory_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteSubcategory($id);
                    }
                    $this->session->set_flashdata('message', lang("subcategories_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('subcategories'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('code'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('main_category'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->settings_model->getSubcategoryDetails($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->code);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->name);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->parent);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'subcategories_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_tax_rate_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function tax_rates()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('tax_rates')));
        $meta = array('page_title' => lang('tax_rates'), 'bc' => $bc);
        $this->page_construct('settings/tax_rates', $meta, $this->data);
    }

    function getTaxRates()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name, code, rate, type")
            ->from("tax_rates")
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_tax_rate/$1') . "' class='tip' title='" . lang("edit_tax_rate") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_tax_rate") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_tax_rate/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_tax_rate()
    {

        $this->form_validation->set_rules('name', lang("name"), 'trim|is_unique[tax_rates.name]|required');
        $this->form_validation->set_rules('code', lang("code"), 'required');
        $this->form_validation->set_rules('type', lang("type"), 'required');
        $this->form_validation->set_rules('rate', lang("tax_rate"), 'required|numeric');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'type' => $this->input->post('type'),
                'rate' => $this->input->post('rate'),
            );
        } elseif ($this->input->post('add_tax_rate')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/tax_rates");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addTaxRate($data)) {
            $this->session->set_flashdata('message', lang("tax_rate_added"));
            redirect("system_settings/tax_rates");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/add_tax_rate', $this->data);
        }
    }

    function edit_tax_rate($id = NULL)
    {

        $this->form_validation->set_rules('name', lang("name"), 'trim|required');
        $tax_details = $this->settings_model->getTaxRateByID($id);
        if ($this->input->post('name') != $tax_details->name) {
            $this->form_validation->set_rules('name', lang("name"), 'is_unique[tax_rates.name]');
        }
        $this->form_validation->set_rules('code', lang("code"), 'required');
        $this->form_validation->set_rules('type', lang("type"), 'required');
        $this->form_validation->set_rules('rate', lang("tax_rate"), 'required|numeric');

        if ($this->form_validation->run() == true) {

            $data = array('name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'type' => $this->input->post('type'),
                'rate' => $this->input->post('rate'),
            );
        } elseif ($this->input->post('edit_tax_rate')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/tax_rates");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateTaxRate($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("tax_rate_updated"));
            redirect("system_settings/tax_rates");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['tax_rate'] = $this->settings_model->getTaxRateByID($id);

            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/edit_tax_rate', $this->data);
        }
    }

    function delete_tax_rate($id = NULL)
    {
        if ($this->settings_model->deleteTaxRate($id)) {
            echo lang("tax_rate_deleted");
        }
    }

    function tax_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteTaxRate($id);
                    }
                    $this->session->set_flashdata('message', lang("tax_rates_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('tax_rates'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('code'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('tax_rate'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('type'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $tax = $this->settings_model->getTaxRateByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $tax->name);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $tax->code);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $tax->rate);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, ($tax->type == 1) ? lang('percentage') : lang('fixed'));
                        $row++;
                    }
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'tax_rates_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_tax_rate_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function customer_groups()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('customer_groups')));
        $meta = array('page_title' => lang('customer_groups'), 'bc' => $bc);
        $this->page_construct('settings/customer_groups', $meta, $this->data);
    }

    function getCustomerGroups()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name, percent")
            ->from("customer_groups")
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_customer_group/$1') . "' class='tip' title='" . lang("edit_customer_group") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_customer_group") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_customer_group/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_customer_group()
    {

        $this->form_validation->set_rules('name', lang("group_name"), 'trim|is_unique[customer_groups.name]|required');
        $this->form_validation->set_rules('percent', lang("group_percentage"), 'required|numeric');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'),
                'percent' => $this->input->post('percent'),
            );
        } elseif ($this->input->post('add_customer_group')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/customer_groups");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addCustomerGroup($data)) {
            $this->session->set_flashdata('message', lang("customer_group_added"));
            redirect("system_settings/customer_groups");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/add_customer_group', $this->data);
        }
    }

    function edit_customer_group($id = NULL)
    {

        $this->form_validation->set_rules('name', lang("group_name"), 'trim|required');
        $pg_details = $this->settings_model->getCustomerGroupByID($id);
        if ($this->input->post('name') != $pg_details->name) {
            $this->form_validation->set_rules('name', lang("group_name"), 'is_unique[tax_rates.name]');
        }
        $this->form_validation->set_rules('percent', lang("group_percentage"), 'required|numeric');

        if ($this->form_validation->run() == true) {

            $data = array('name' => $this->input->post('name'),
                'percent' => $this->input->post('percent'),
            );
        } elseif ($this->input->post('edit_customer_group')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/customer_groups");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateCustomerGroup($id, $data)) {
            $this->session->set_flashdata('message', lang("customer_group_updated"));
            redirect("system_settings/customer_groups");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['customer_group'] = $this->settings_model->getCustomerGroupByID($id);

            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/edit_customer_group', $this->data);
        }
    }

    function delete_customer_group($id = NULL)
    {
        if ($this->settings_model->deleteCustomerGroup($id)) {
            echo lang("customer_group_deleted");
        }
    }

    function customer_group_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteCustomerGroup($id);
                    }
                    $this->session->set_flashdata('message', lang("customer_groups_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('tax_rates'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('group_name'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('group_percentage'));
                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $pg = $this->settings_model->getCustomerGroupByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $pg->name);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $pg->percent);
                        $row++;
                    }
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'customer_groups_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_customer_group_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function warehouses()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('warehouses')));
        $meta = array('page_title' => lang('warehouses'), 'bc' => $bc);
        $this->page_construct('settings/warehouses', $meta, $this->data);
    }

    function getWarehouses()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, map, code, name, phone, email, address")
            ->from("warehouses")
            //->edit_column("map", base_url().'assets/uploads/$1', 'map')
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_warehouse/$1') . "' class='tip' title='" . lang("edit_warehouse") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_warehouse") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_warehouse/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
        //->unset_column('id')
        //->unset_column('map');

        echo $this->datatables->generate();
    }

    function add_warehouse()
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("code"), 'trim|is_unique[warehouses.code]|required');
        $this->form_validation->set_rules('name', lang("name"), 'required');
        $this->form_validation->set_rules('address', lang("address"), 'required');
        $this->form_validation->set_rules('userfile', lang("map_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            if ($_FILES['userfile']['size'] > 0) {

                $this->load->library('upload');

                $config['upload_path'] = 'assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '1024';
                $config['max_width'] = '2000';
                $config['max_height'] = '2000';
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', $error);
                    redirect("system_settings/warehouses");
                }

                $map = $this->upload->file_name;

                $this->load->helper('file');
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/uploads/' . $map;
                $config['new_image'] = 'assets/uploads/thumbs/' . $map;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 76;
                $config['height'] = 76;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
            } else {
                $map = NULL;
            }
            $data = array('code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'map' => $map,
            );
        } elseif ($this->input->post('add_warehouse')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/warehouses");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addWarehouse($data)) {
            $this->session->set_flashdata('message', lang("warehouse_added"));
            redirect("system_settings/warehouses");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/add_warehouse', $this->data);
        }
    }

    function edit_warehouse($id = NULL)
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("code"), 'trim|required');
        $wh_details = $this->settings_model->getWarehouseByID($id);
        if ($this->input->post('code') != $wh_details->code) {
            $this->form_validation->set_rules('code', lang("code"), 'is_unique[warehouses.code]');
        }
        $this->form_validation->set_rules('address', lang("address"), 'required');
        $this->form_validation->set_rules('map', lang("map_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            $data = array('code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
            );

            if ($_FILES['userfile']['size'] > 0) {

                $this->load->library('upload');

                $config['upload_path'] = 'assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '1024';
                $config['max_width'] = '2000';
                $config['max_height'] = '2000';
                $config['overwrite'] = FALSE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', $error);
                    redirect("system_settings/warehouses");
                }

                $data['map'] = $this->upload->file_name;

                $this->load->helper('file');
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/uploads/' . $data['map'];
                $config['new_image'] = 'assets/uploads/thumbs/' . $data['map'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 76;
                $config['height'] = 76;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
            }
        } elseif ($this->input->post('edit_warehouse')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/warehouses");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateWarehouse($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("warehouse_updated"));
            redirect("system_settings/warehouses");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['warehouse'] = $this->settings_model->getWarehouseByID($id);

            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/edit_warehouse', $this->data);
        }
    }

    function delete_warehouse($id = NULL)
    {
        if ($this->settings_model->deleteWarehouse($id)) {
            echo lang("warehouse_deleted");
        }
    }

    function warehouse_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteWarehouse($id);
                    }
                    $this->session->set_flashdata('message', lang("warehouses_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('warehouses'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('code'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('address'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('city'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $wh = $this->settings_model->getWarehouseByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $wh->code);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $wh->name);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $wh->address);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $wh->city);
                        $row++;
                    }
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'warehouses_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_warehouse_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function variants()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('variants')));
        $meta = array('page_title' => lang('variants'), 'bc' => $bc);
        $this->page_construct('settings/variants', $meta, $this->data);
    }

    function getVariants()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name")
            ->from("variants")
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_variant/$1') . "' class='tip' title='" . lang("edit_variant") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_variant") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_variant/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_variant()
    {

        $this->form_validation->set_rules('name', lang("name"), 'trim|is_unique[variants.name]|required');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_variant')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/variants");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addVariant($data)) {
            $this->session->set_flashdata('message', lang("variant_added"));
            redirect("system_settings/variants");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/add_variant', $this->data);
        }
    }

    function edit_variant($id = NULL)
    {

        $this->form_validation->set_rules('name', lang("name"), 'trim|required');
        $tax_details = $this->settings_model->getVariantByID($id);
        if ($this->input->post('name') != $tax_details->name) {
            $this->form_validation->set_rules('name', lang("name"), 'is_unique[variants.name]');
        }

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_variant')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/variants");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateVariant($id, $data)) {
            $this->session->set_flashdata('message', lang("variant_updated"));
            redirect("system_settings/variants");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['variant'] = $tax_details;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/edit_variant', $this->data);
        }
    }

    function delete_variant($id = NULL)
    {
        if ($this->settings_model->deleteVariant($id)) {
            echo lang("variant_deleted");
        }
    }

    function per_types()
    {
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('per_types')));
        $meta = array('page_title' => lang('per_types'), 'bc' => $bc);
        $this->page_construct('settings/per_types', $meta, $this->data);
    }

    function getPerType()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, image, code, name")
            ->from("per_types")
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_per_types/$1') . "' data-toggle='modal' data-target='#myModal' class='tip' title='" . lang("edit_per_types") . "'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_per_types") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_per_types/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");

        echo $this->datatables->generate();
    }
    function add_per_types()  
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("per_types_code"), 'trim|is_unique[per_types.code]|required');
        $this->form_validation->set_rules('name', lang("per_types_name"), 'required');
        $this->form_validation->set_rules('userfile', lang("per_types_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            $name = $this->input->post('name');
            $code = $this->input->post('code');

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->Settings->iwidth;
                $config['max_height'] = $this->Settings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                //$data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->Settings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'right';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            } else {
                $photo = NULL;
            }
        } elseif ($this->input->post('add_per_type')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/per_types");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addPerType($name, $code, $photo)) {
            $this->session->set_flashdata('message', lang("per_types_added"));
            redirect("system_settings/per_types");
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

            $this->data['name'] = array('name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['code'] = array('name' => 'code',
                'id' => 'code',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('code'),
            );
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/add_per_type', $this->data);
        }
    }

    function edit_per_types($id = NULL)
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("per_types_code"), 'trim|required');
        $pr_details = $this->settings_model->getPerTypeByID($id);
        if ($this->input->post('code') != $pr_details->code) {
            $this->form_validation->set_rules('code', lang("per_types_code"), 'is_unique[per_types.code]');
        }
        $this->form_validation->set_rules('name', lang("per_types_name"), 'required');
        $this->form_validation->set_rules('userfile', lang("per_types_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            $data = array('code' => $this->input->post('code'),
                'name' => $this->input->post('name')
            );
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->Settings->iwidth;
                $config['max_height'] = $this->Settings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                //$data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->Settings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'right';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            } else {
                $photo = NULL;
            }
        } elseif ($this->input->post('edit_per_type')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/per_types");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updatePerType($id, $data, $photo)) {
            $this->session->set_flashdata('message', lang("per_types_updated"));
            redirect("system_settings/per_types");
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $per_type = $this->settings_model->getPerTypeByID($id);
            $this->data['name'] = array('name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('name', $per_type->name),
            );
            $this->data['code'] = array('name' => 'code',
                'id' => 'code',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('code', $per_type->code),
            );

            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/edit_per_type', $this->data);
        }
    }

    function delete_per_types($id = NULL)
    {
        if ($this->settings_model->deletePerType($id)) {
            echo lang("per_type_deleted");
        }
    }

    function per_types_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deletePerType($id);
                    }
                    $this->session->set_flashdata('message', lang("per_types_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('per_types'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('code'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->settings_model->getPerTypeByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->code);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->name);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'per_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_per_types_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
    function bank_details()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('bank_details')));
        $meta = array('page_title' => lang('bank_details'), 'bc' => $bc);
        $this->page_construct('settings/bank_details', $meta, $this->data);
    }

    function getBankDetails()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select("id, bank_name, bank_branch, bank_account_no, bank_ifsc_code")
            ->from("bank_details")
            ->add_column("Actions", "<center><a href='" . site_url('system_settings/edit_bank_details/$1') . "' data-toggle='modal' data-target='#myModal' class='tip' title='" . lang("edit_bank_detail") . "'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_bank_detail") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('system_settings/delete_bank_details/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");

        echo $this->datatables->generate();
    }
    function add_bank_details()  
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('bank_ifsc_code', lang("bank_ifsc"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_name', lang("bank_name"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_branch', lang("bank_branch"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_account_no', lang("bank_accno"), 'trim|required|is_unique[bank_details.bank_account_no]|xss_clean');
        
        if ($this->form_validation->run() == true) {
            $bank_name = $this->input->post('bank_name');
            $bank_branch = $this->input->post('bank_branch');
            $bank_account_no = $this->input->post('bank_account_no');
            $bank_ifsc_code = $this->input->post('bank_ifsc_code');
          
        } elseif ($this->input->post('add_bank_detail')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/bank_details");
        }

        if ($this->form_validation->run() == true && $this->settings_model->addBankDetail($bank_name, $bank_branch, $bank_account_no, $bank_ifsc_code)) {
            $this->session->set_flashdata('message', lang("bank_detail_added"));
            redirect("system_settings/bank_details");
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

            $this->data['bank_name'] = array('name' => 'bank_name',
                'id' => 'bank_name',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('bank_name'),
            );
            $this->data['bank_branch'] = array('name' => 'bank_branch',
                'id' => 'bank_branch',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('bank_branch'),
            );
            $this->data['bank_account_no'] = array('name' => 'bank_account_no',
                'id' => 'bank_account_no',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('bank_account_no'),
            );
            $this->data['bank_ifsc_code'] = array('name' => 'bank_ifsc_code',
                'id' => 'bank_ifsc_code',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('bank_ifsc_code'),
            );
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'settings/add_bank_detail', $this->data);
        }
    }

    function edit_bank_details($id = NULL)
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('bank_account_no', lang("bank_accno"), 'trim|required');
        $pr_details = $this->settings_model->getBankDetailByID($id);
        if ($this->input->post('bank_account_no') != $pr_details->bank_account_no) {
            $this->form_validation->set_rules('bank_account_no', lang("bank_accno"), 'is_unique[bank_details.bank_account_no]');
        }
        $this->form_validation->set_rules('bank_ifsc_code', lang("bank_ifsc"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_name', lang("bank_name"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_branch', lang("bank_branch"), 'trim|required|xss_clean');
        
        if ($this->form_validation->run() == true) {

            $data = array('bank_name' => $this->input->post('bank_name'),
                'bank_branch' => $this->input->post('bank_branch'),
                'bank_account_no' => $this->input->post('bank_account_no'),
                'bank_ifsc_code' => $this->input->post('bank_ifsc_code')
                );
            
        } elseif ($this->input->post('edit_bank_detail')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("system_settings/bank_details");
        }

        if ($this->form_validation->run() == true && $this->settings_model->updateBankDetail($id, $data)) {
            $this->session->set_flashdata('message', lang("bank_detail_updated"));
            redirect("system_settings/bank_details");
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $bank_detail = $this->settings_model->getBankDetailByID($id);
            $this->data['bank_name'] = array('name' => 'bank_name',
                'id' => 'bank_name',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('bank_name', $bank_detail->bank_name),
            );
            $this->data['bank_branch'] = array('name' => 'bank_branch',
                'id' => 'bank_branch',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('bank_branch', $bank_detail->bank_branch),
            );
            $this->data['bank_account_no'] = array('name' => 'bank_account_no',
                'id' => 'bank_account_no',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('bank_account_no', $bank_detail->bank_account_no),
            );
            $this->data['bank_ifsc_code'] = array('name' => 'bank_ifsc_code',
                'id' => 'bank_ifsc_code',
                'type' => 'text',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('bank_ifsc_code', $bank_detail->bank_ifsc_code),
            );

            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['id'] = $id;
            $this->load->view($this->theme . 'settings/edit_bank_detail', $this->data);
        }
    }

    function delete_bank_details($id = NULL)
    {
        if ($this->settings_model->deleteBankDetail($id)) {
            echo lang("bank_detail_deleted");
        }
    }

    function bank_details_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->settings_model->deleteBankDetail($id);
                    }
                    $this->session->set_flashdata('message', lang("bank_details_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('bank_details'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('bank_name'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('bank_branch'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('bank_accno'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('bank_ifsc'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->settings_model->getBankDetailByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->bank_name);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->bank_branch);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->bank_account_no);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sc->bank_ifsc_code);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'bankdetails_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_bank_details_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
    function sms_templates($template = "credentials")
    {

        $this->form_validation->set_rules('sms_body', lang('sms_message'), 'trim|required');
        $this->form_validation->set_rules('sms_sent', lang('sent'), 'trim|required');
        if ($this->form_validation->run() == true) {
            $sms_body = $_POST["sms_body"];
            $sms_sent = $_POST["sms_sent"];
            $field = $template;
            $field_sent = $template.'_sent';
            $this->site->updateSms($field, $sms_body, $field_sent, $sms_sent);
            redirect("system_settings/sms_templates");
        } else {
            $sms = $this->site->getAllSms();
            $this->data['credentials'] = strip_tags($sms->credentials);
            $this->data['sale'] = strip_tags($sms->sale);
            $this->data['purchase'] = strip_tags($sms->purchase);
            $this->data['payment'] = strip_tags($sms->payment);
            $this->data['credentials_sent'] = $sms->credentials_sent;
            $this->data['sale_sent'] = $sms->sale_sent;
            $this->data['purchase_sent'] = $sms->purchase_sent;
            $this->data['payment_sent'] = $sms->payment_sent;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('system_settings'), 'page' => lang('system_settings')), array('link' => '#', 'page' => lang('sms_templates')));
            $meta = array('page_title' => lang('sms_templates'), 'bc' => $bc);
            $this->page_construct('settings/sms_templates', $meta, $this->data);
        }
    }

}
