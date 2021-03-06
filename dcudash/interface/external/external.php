<?php
/**
 * @brief		Dashes External Block Gateway
 * @package		DCU Dashboard
 * @author		Gary Cornell for devCU Software Open Source Projects
 * @copyright		(c) 2018 devCU Software
 * @contact		gary@devcu.com
 * @site		https://www.devcu.com
 * @Source		https://github.com/devCU/DCU-Dashboard 
 * @subpackage		Dashboard Content
 * @base		IPS 4 CMS
 * @since		13 JAN 2019
 * @version		1.0.0
 */

define('REPORT_EXCEPTIONS', TRUE);
require_once str_replace( 'applications/dcudash/interface/external/external.php', '', str_replace( '\\', '/', __FILE__ ) ) . 'init.php';
\IPS\Dispatcher\External::i();

$id = \IPS\Request::i()->blockid;
$k = \IPS\Request::i()->widgetid;
$block = \IPS\dcudash\Blocks\Block::display( $id );

\IPS\Output::i()->jsFiles = array_merge( \IPS\Output::i()->jsFiles, \IPS\Output::i()->js( 'front_external.js', 'dcudash', 'front' ) );
\IPS\Output::i()->globalControllers[] = 'dcudash.front.external.communication';
\IPS\Output::i()->sendOutput( \IPS\Theme::i()->getTemplate( 'global', 'core' )->blankTemplate( $block ), 200, 'text/html' );