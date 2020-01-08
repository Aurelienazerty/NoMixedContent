<?php
/**
 *
 * Display Last Post extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace Aurelienazerty\NoMixedContent\event;

/**
 * Event listener
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	/** @var \phpbb\config\config */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config	$config	Config object
	 * @return \Aurelienazerty\DisplayLastPost\event\listener
	 * @access public
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_post_row'	=> 'switch_https',
		);
	}

	/**
	 * Modify the firt post of the topic
	 * (only if it's not the first page)
	 *
	 * @param object $event The event object
	 *
	 * @return null
	 * @access public
	 */
	public function switch_https($event)
	{
		$post_row = $event['post_row'];
		
		$in = array();
		$out = array();
		
		$in[] = 'http://www.team-azerty.com'; $out[] = 'https://www.team-azerty.com';
		$in[] = 'http://team-azerty.com'; $out[] = 'https://www.team-azerty.com';
		/*$in[] = 'https://'; $out[] = '//';
		$in[] = 'http://'; $out[] = '//';*/
		
		$post_row['MESSAGE'] = str_replace($in, $out, $post_row['MESSAGE']);
		$event['post_row'] = $post_row;
	}

}
