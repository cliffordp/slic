<?php

namespace TEC\Tric;

if ( $is_help ) {
	echo "Runs a Codeception command in the stack, the equivalent of <light_cyan>'codecept ...'</light_cyan>.\n";
	echo PHP_EOL;
	echo colorize( "This command requires a use target set using the <light_cyan>use</light_cyan> command.\n" );
	echo colorize( "usage: <light_cyan>{$cli_name} cc [...<commands>]</light_cyan>\n" );
	echo colorize( "example: <light_cyan>{$cli_name} cc generate:wpunit wpunit Foo</light_cyan>" );

	return;
}

$using = tric_target_or_fail();
echo light_cyan( "Using {$using}\n" );

setup_id();
ensure_tric_service_running();

$status = tric_realtime()( array_merge( [
		'exec',
		'--user',
		sprintf( '"%s:%s"', getenv( 'DOCKER_RUN_UID' ), getenv( 'DOCKER_RUN_GID' ) ),
		'--workdir',
		escapeshellarg( get_project_container_path() ),
		'tric',
		'vendor/bin/codecept'
	], $args( '...' ) )
);

exit( $status );
