<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/4
 * Time: 下午5:51
 *
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use ezswoole\Validator;

/**
 * 店铺
 * Class Shop
 * @package App\HttpController\Admin
 */
class Shop extends Admin
{
	/**
	 * 店铺基础信息设置
	 * @method POST
	 * @param  string $name
	 * @param  string $logo
	 * @param  string $contact_number
	 * @param  string $description
	 * @param  string $host
	 */
	public function setBaseInfo()
	{
		if( $this->validator( $this->post, 'Admin/Shop.setBaseInfo' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$data = [];
			if( isset( $this->post['logo'] ) ){
				$data['logo'] = $this->post['logo'];
			}
			if( isset( $this->post['name'] ) ){
				$data['name'] = $this->post['name'];
			}
			if( isset( $this->post['contact_number'] ) ){
				$data['contact_number'] = $this->post['contact_number'];
			}
			if( isset( $this->post['description'] ) ){
				$data['description'] = $this->post['description'];
			}
			if( isset( $this->post['host'] ) ){
				$data['host'] = $this->post['host'];
			}
			\App\Model\Shop::init()->editShop( ['id' => 1], $data );
			$this->send( Code::success, [] );
		}
	}

	/**
	 * 店铺配色方案设置
	 * @method POST
	 * @param  string $color_scheme
	 */
	public function setColorScheme()
	{
		if( $this->validator( $this->post, 'Admin/Shop.setColorScheme' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\Shop::init()->editShop( ['id' => 1], ['color_scheme' => $this->post['color_scheme']] );
			$this->send( Code::success, [] );
		}
	}

	/**
	 * 店铺首页模板选择【废弃】
	 * @method POST
	 * @param  int $portal_template_id
	 */
	public function setPortalTemplate()
	{
		if( $this->validator( $this->post, 'Admin/Shop.setPortalTemplate' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\Shop::init()->editShop( ['id' => 1], ['portal_template_id' => $this->post['portal_template_id']] );
			$this->send( Code::success, [] );
		}
	}

	/**
	 * 店铺信息
	 * @method GET
	 */
	public function info()
	{
		$shop     = \App\Model\Shop::init()->getShopInfo( ['id' => 1] );
		$validate = new Validator();
		if( $shop['host'] && $validate->is( $shop['host'], 'url' ) === true ){
			$shop['portal_url'] = rtrim( $shop['host'], '/' )."/mobile";
		} else{
			$shop['portal_url'] = $this->request->domain()."/mobile";
		}
		return $this->send( Code::success, ['info' => $shop] );
	}

	/**
	 * 店铺分类页风格设置
	 * @method POST
	 * @param  int $goods_category_style
	 */
	public function setGoodsCategoryStyle()
	{
		if( $this->validator( $this->post, 'Admin/Shop.setGoodsCategoryStyle' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\Shop::init()->editShop( ['id' => 1], ['goods_category_style' => $this->post['goods_category_style']] );
			$this->send( Code::success );
		}
	}

	/**
	 * 设置订单相关过期时间
	 * @method POST
	 * @param int $order_auto_close_expires         待付款订单N秒后自动关闭订单，默认604800秒
	 * @param int $order_auto_confirm_expires       已发货订单后自动确认收货，默认604800秒
	 * @param int $order_auto_close_refound_expires 已收货订单后关闭退款／退货功能，0代表确认收货后无法维权，默认0秒
	 */
	public function setOrderExpires()
	{
		if( $this->validator( $this->post, 'Admin/Shop.setOrderExpires' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			\App\Model\Shop::init()->editShop( ['id' => 1], [
				'order_auto_close_expires'         => $this->post['order_auto_close_expires'],
				'order_auto_confirm_expires'       => $this->post['order_auto_confirm_expires'],
				'order_auto_close_refound_expires' => $this->post['order_auto_close_refound_expires'],
			] );
			$this->send( Code::success );
		}
	}
}