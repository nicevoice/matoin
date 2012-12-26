<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * matoin System
 *
 * 猫头鹰matoin - 帮你寻找最有价值的东西
 *
 * matoin - to help you find the most valuable thing
 *
 * @package    matoin
 * @author     yzg <yangzhiguo0903@gmail.com>
 * @copyright  Copyright (c) 2011 - 2012, matoin.com.
 * @license    GNU General Public License 2.0
 * @link       http://www.matoin.com/
 * @version    $Id home.php v1.0.0 2012-01-08 03:50 $
 */

// ------------------------------------------------------------------------

/**
 * home.php控制器
 *
 * 主页
 *
 * @package     matoin
 * @subpackage  Controllers
 * @category    Front-controllers
 * @author      yzg <yangzhiguo0903@gmail.com>
 * @link        http://www.matoin.com/
 */
class Home extends MT_Controller
{
    public function index()
    {
        $this->load->model('Image_model');
        $this->load->library('pagination');

        $pagesize = 16;
        $config['base_url']   = base_url();
        $config['total_rows'] = 16 * 30;
        $config['per_page']   = $pagesize;

        $this->pagination->initialize($config);
        $offset = (int)$this->input->get($this->pagination->query_string_segment);

        $data['page'] = $this->pagination->create_links();
        $condition = array(
            'limit'  => $pagesize,
            'offset' => ($offset - 1) * $pagesize
        );
        $data['imagelist'] = $this->Image_model->get_custom_image($condition);
//        $this->output->enable_profiler(TRUE);
        $this->template('common/header,content/index,common/footer', $data);
    }

    public function hot()
    {
        $this->load->model('Image_model');

        $pagesize = 20;
        $option = array(
            'limit'  => $pagesize,
            'offset' => 0,
            'order'  => 'favetimes',
            'sort'   => 'DESC'
        );
        $condition = array(
            'dateline >' => TIME - 604800
        );
        $data['imagelist'] = $this->Image_model->get_custom_image($option, $condition);
        $this->template('common/header,content/index,common/footer', $data);
    }
}

//END Home Class

/* End of file home.php */
/* Location: ./application/controllers/home.php */