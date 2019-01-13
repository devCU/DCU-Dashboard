<?php
/**
 * @brief		Upgrader: Custom Upgrade Options
 * @author		<a href='https://www.invisioncommunity.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) Invision Power Services, Inc.
 * @license		https://www.invisioncommunity.com/legal/standards/
 * @package		Invision Community
 * @subpackage	Content
 * @since		3 Mar 2015
 */

$options = array();

foreach( \IPS\Db::i()->select( '*', 'dcud_databases' ) as $database )
{
	/* Show warning about inability to convert html */
	$options[] = new \IPS\Helpers\Form\Custom( '40000_dcudash_htmlconversion', null, FALSE, array( 'getHtml' => function( $element ) use ( $members ){
		return "";
	} ), function( $val ) {}, NULL, NULL, '40000_dcudash_htmlconversion' );

	$dashes = array();

	foreach( \IPS\Db::i()->select( '*', 'dcud_dashes' ) as $dash )
	{
		if( $database['database_is_dashboards'] AND mb_strpos( $dash['dash_content'], "{parse dashboards" ) !== FALSE )
		{
			$dashes[ $dash['dash_id'] ] = $dash['dash_name'] . ' (' . $dash['dash_seo_name'] . ')';
		}

		if( mb_strpos( $dash['dash_content'], "{parse database=\"{$database['database_id']}\"" ) !== FALSE OR mb_strpos( $dash['dash_content'], "{parse database=\"{$database['database_key']}\"" ) !== FALSE )
		{
			$dashes[ $dash['dash_id'] ] = $dash['dash_name'] . ' (' . $dash['dash_seo_name'] . ')';
		}
	}

	if( count( $dashes ) > 1 )
	{
		\IPS\Member::loggedIn()->language()->words[ '40000_database_dash_' . $database['database_id'] ] = sprintf( \IPS\Member::loggedIn()->language()->get( 'dcudash_database_title' ), $database['database_name'] );
		\IPS\Member::loggedIn()->language()->words[ '40000_database_dash_' . $database['database_id'] . '_desc' ] = \IPS\Member::loggedIn()->language()->get( 'dcudash_database_desc' );

		$options[]	= new \IPS\Helpers\Form\Radio( '40000_database_dash_' . $database['database_id'], 0, TRUE, array( 'options' => $dashes ) );
	}
}