<?php
    in_file();

    class about extends controller
    {
        protected $vars = [], $errors = [];

        public function __construct(){
            parent::__construct();
            $this->load->helper('website');
            $this->load->lib('session', ['DmNCMS']);
			$this->session->checkSession();
			$this->load->lib('csrf');						 
            $this->load->helper('breadcrumbs', [$this->request]);
            $this->load->helper('meta');
        }

        public function index(){
            $this->load->view($this->config->config_entry('main|template') . DS . 'about' . DS . 'view.about');
        }

        public function stats($server = ''){
            if($server != ''){
                $this->vars['server'] = $server;
                $this->vars['title'] = $this->website->get_value_from_server($server, 'title');
            } 
            else{
                throw new Exception(__('Invalid server selected'));
            }
            
            $this->load->model('stats');
            $this->vars['stats'] = $this->Mstats->server_stats($server);
            
			if(MU_VERSION >= 1){
				$this->vars['crywolf_state'] = $this->Mstats->get_crywolf_state($server);
			}
            
            $this->vars['cs_info'] = $this->Mstats->get_cs_info($server);
            $this->vars['cs_guild_list'] = $this->Mstats->get_cs_guild_list($server);
            $this->load->view($this->config->config_entry('main|template') . DS . 'about' . DS . 'view.stats', $this->vars);
        }
    }