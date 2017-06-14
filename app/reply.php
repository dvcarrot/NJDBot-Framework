<?php
namespace app;

class Reply
{
	//текстовое сообщние
	public $textTelegram = null; 
	public $textVk = null; 
	public $textViber = null; 
	public $vkAttachment = null;

	public $image = null; //картинка
	public $audio = null; //музыка
	public $video = null; //видео
	public $keyboard = [ //кнопки клавиатуры
		'keyboard' => [], 
		'resize_keyboard' => true, 
		'one_time_keyboard' => false,
		'inline_keyboard' => [],
	]; 
	public $location = null; //место на карте
	public $document = null; //документ
	/*
	public $message = null; //пересылаемое сообщение
	public $sticker = null; //стикер
	public $link = null; //ссылка
	public $product = null; //товар
	//public $chatAcion ????
	*/	
}