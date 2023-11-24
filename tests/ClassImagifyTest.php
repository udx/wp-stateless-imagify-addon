<?php

namespace WPSL\Imagify;

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;
use Brain\Monkey\Actions;
use Brain\Monkey\Filters;
use Brain\Monkey\Functions;
use wpCloud\StatelessMedia\WPStatelessStub;

/**
 * Class ClassImagifyTest
 */

class ClassImagifyTest extends TestCase {
  // Adds Mockery expectations to the PHPUnit assertions count.
  use MockeryPHPUnitIntegration;

  public function setUp(): void {
		parent::setUp();
		Monkey\setUp();
  }
	
  public function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

  public function testShouldInitHooks() {
    $imagify = new Imagify();

    $imagify->module_init([]);

    self::assertNotFalse( has_filter('before_imagify_optimize_attachment', [ $imagify, 'fix_missing_file' ]) );
    self::assertNotFalse( has_filter('wp_stateless_skip_remove_media', [ $imagify, 'skip_remove_media' ]) );
    self::assertNotFalse( has_filter('imagify_has_backup', [ $imagify, 'imagify_has_backup' ]) );
    self::assertNotFalse( has_filter('before_imagify_restore_attachment', [ $imagify, 'get_image_from_gcs' ]) );

    self::assertNotFalse( has_action('after_imagify_optimize_attachment', [ $imagify, 'after_imagify_optimize_attachment' ]) );
    self::assertNotFalse( has_action('imagify_after_optimize_file', [ $imagify, 'imagify_after_optimize_file' ]) );
    self::assertNotFalse( has_action('imagify_before_optimize_size', [ $imagify, 'imagify_before_optimize_size' ]) );
    self::assertNotFalse( has_action('after_imagify_restore_attachment', [ $imagify, 'after_imagify_optimize_attachment' ]) );
    self::assertNotFalse( has_action('sm:synced::image', [ $imagify, 'get_image_from_gcs' ]) );
  }
}
