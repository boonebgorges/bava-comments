<?php

class BavaComments_Tests extends WP_UnitTestCase {

	public function test_gif_on_own_line_should_be_converted_to_img_tag() {
		$text = 'foo

http://example.com/foo.gif

bar';

		$this->assertContains( '<img src="http://example.com/foo.gif"', bava_comments_filter( $text ) );
	}

	public function test_jpg_on_own_line_should_be_converted_to_img_tag() {
		$text = 'foo

http://example.com/foo.jpg

bar';

		$this->assertContains( '<img src="http://example.com/foo.jpg"', bava_comments_filter( $text ) );
	}

	public function test_giphy_url_on_own_line_should_be_converted_to_img_tag() {
		$text = 'foo

http://giphy.com/gifs/colbertlateshow-the-late-show-with-stephen-colbert-3oEjHFFPj80amL7lKg

bar';

		$this->assertContains( '<img src="https://media.giphy.com/media/3oEjHFFPj80amL7lKg/giphy.gif"', bava_comments_filter( $text ) );
	}

	public function test_giphy_url_on_own_line_should_be_converted_to_img_tag_when_slug_isnt_pretty() {
		$text = 'foo

http://giphy.com/gifs/3oEjHFFPj80amL7lKg

bar';

		$this->assertContains( '<img src="https://media.giphy.com/media/3oEjHFFPj80amL7lKg/giphy.gif"', bava_comments_filter( $text ) );
	}
}

