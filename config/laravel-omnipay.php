<?php

$rsa_private_key_yinyou = <<< EOT
-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQDRsVLarIRTZ0Z/+CuRYb34cIqKbOb4XFHYgjJCLFLcykTCP6Tx
XuCRGZCe4CXNLzqiAkmqifSv71GU6y5vQIqYesZF5Ps/U/2ylGwmFYHLl3bJZafG
LO7BLI0y/2/hT7oULR4YRHQpyyl1XRmNUYdJCkTrpN9RVEd/87XxnjgdTQIDAQAB
AoGAMWYTvb4sgjVvL1B4ewxKo49no8qZ8uJUyauKSXqFnsvrvNMfeVk/kA80uajW
XusEZgwh7JIJWbUIRAvPaZgLzgjVUFYqHQ3SEIcRdwzc9/zWa67OTxNlDQKlPgic
WbbzfDqQi/pJtxIWFBpZ79H30MLcP+qYRojk7ZH8PsLL9oECQQDs6XJA18QpATp3
RBT0jg7r6/cmr0RG2GYZ1aGVnFXNtpxIzJR3CjTrwJ3YO7IB/rh0NOvJhspvvf5J
GUBYSfqtAkEA4pZz17MBhykAQu3UxFyAKvakMhqNC9/L2SAvb7kTXuhOFuD3zvpG
Y9vyW23Yub5GwTDEmPejxlF0J3CXFyihIQJAO++DXCw6EDWjWPD8bDJUTBNSX5MP
ruyoR/jn/DWk73o3Z6N6G/OVF9+PD1lq215Zw+xvinhzVnm2jz+4K53rsQJAQWrg
jRDQSx5qReh2Oi7ejgjhRNnniNsW9lvVdjL/xbHaAb73rJkTQ3dX1E+1d4LY2KPk
zqkIbpRLratS48vGIQJAHLuvlTnzEen5qSoYZRfYvmWyifgq2/TLaWA0KaIUhCu2
nPmPDghUzkAzdmUukXzEBpX081Cw39vPsoIYMwhKAA==
-----END RSA PRIVATE KEY-----
EOT;


return [

	// The default gateway to use
	'default' => 'alipay',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		],
		'alipay' => [
			'driver' => 'Alipay_AopWap',
			'options' => [
				'appID' => '2088221173454605',
				'privateKey' => $rsa_private_key_yinyou,
				'alipayPublicKey' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB',
				'notifyUrl' => 'http://www.uugame.cn/alipay/notify',
			],
			'method' => 'getRedirectUrl'
		],
		'alipay_app' => [
			'driver' => 'Alipay_AopApp',
			'options' => [
				'appID' => '2016071401616507',
				'privateKey' => $rsa_private_key_yinyou,
				'alipayPublicKey' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB',
				'notifyUrl' => 'http://115.159.113.93:8008/mobilepay/alipayapp/notify',
			],
			'method' => 'getOrderString'
		],
		'wechatpay' => [
			'driver' => 'WechatPay_Native',
			'options' => [
				'appID' => 'wxc0c2e8ea437cf3cc',
				'mchID' => '1392137402',
				'apiKey' => 'MBUMaqGD3WmTOSOgu2zFN5p5RvicBZqP',
				'notifyUrl' => 'http://115.159.113.93:8008/mobilepay/alipayapp/notify',

			],
			'method' => 'getCodeUrl'
		],
		'wechatpay_app' => [
			'driver' => 'WechatPay_App',
			'options' => [
				'appID' => 'wxc0c2e8ea437cf3cc',
				'mchID' => '1392137402',
				'apiKey' => 'MBUMaqGD3WmTOSOgu2zFN5p5RvicBZqP',
				'notifyUrl' => 'http://115.159.113.93:8008/mobilepay/alipayapp/notify',

			],
			'method' => 'getAppOrderData'
		]
	]

];