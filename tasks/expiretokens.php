<?php
/**
 * @brief		expiretokens Task
 * @author		<a href='http://www.invisionpower.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) 2001 - 2016 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/legal/standards/
 * @package		IPS Community Suite
 * @subpackage	oauth2server
 * @since		28 May 2016
 * @version		SVN_VERSION_NUMBER
 */

namespace IPS\oauth2server\tasks;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * expiretokens Task
 */
class _expiretokens extends \IPS\Task
{
	/**
	 * Execute
	 *
	 * If ran successfully, should return anything worth logging. Only log something
	 * worth mentioning (don't log "task ran successfully"). Return NULL (actual NULL, not '' or 0) to not log (which will be most cases).
	 * If an error occurs which means the task could not finish running, throw an \IPS\Task\Exception - do not log an error as a normal log.
	 * Tasks should execute within the time of a normal HTTP request.
	 *
	 * @return	mixed	Message to log or NULL
	 * @throws	\IPS\Task\Exception
	 */
	public function execute()
	{
        $now = new \DateTime();
        \IPS\Db::i()->delete( 'oauth2server_access_tokens', array ( 'expires < ?', $now->format('Y-m-d H:i:s') ));
        \IPS\Db::i()->delete( 'oauth2server_refresh_tokens', array ( 'expires < ?', $now->format('Y-m-d H:i:s') ));
        \IPS\Db::i()->delete( 'oauth2server_authorization_codes', array ( 'expires < ?', $now->format('Y-m-d H:i:s') ));
		return NULL;
	}
	
	/**
	 * Cleanup
	 *
	 * If your task takes longer than 15 minutes to run, this method
	 * will be called before execute(). Use it to clean up anything which
	 * may not have been done
	 *
	 * @return	void
	 */
	public function cleanup()
	{
		
	}
}