<?php
/**
 * @group PortableInfobox
 * @covers PortableInfobox\Parser\Nodes\NodeNavigation
 */
class NodeNavigationTest extends MediaWikiTestCase {

	/**
	 * @covers       PortableInfobox\Parser\Nodes\NodeNavigation::getData
	 * @covers       PortableInfobox\Parser\Nodes\Node::getInnerValue
	 * @dataProvider dataProvider
	 *
	 * @param $markup
	 * @param $expected
	 */
	public function testData( $markup, $expected ) {
		$node = PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup );

		$this->assertEquals( $expected, $node->getData() );
	}

	public function dataProvider() {
		return [
			[
				'<navigation></navigation>',
				[ 'value' => '', 'item-name' => null ]
			],
			[
				'<navigation>kjdflkja dafkjlsdkfj</navigation>',
				[ 'value' => 'kjdflkja dafkjlsdkfj', 'item-name' => null ]
			],
			[
				'<navigation>kjdflkja<ref>dafkjlsdkfj</ref></navigation>',
				[ 'value' => 'kjdflkja<ref>dafkjlsdkfj</ref>', 'item-name' => null ]
			],
			[
				'<navigation name="ihatetests">kjdflkja dafkjlsdkfj</navigation>',
				[ 'value' => 'kjdflkja dafkjlsdkfj', 'item-name' => 'ihatetests' ]
			]
		];
	}

	/**
	 * @dataProvider isEmptyDataProvider
	 */
	public function testIsEmpty( $string, $expectedOutput ) {
		$xml = simplexml_load_string( $string );
		$node = new PortableInfobox\Parser\Nodes\NodeNavigation( $xml, [] );
		$data = $node->getData();
		$this->assertTrue( $node->isEmpty( $data ) == $expectedOutput );
	}

	public function isEmptyDataProvider() {
		return [
			[
				'string' => '<navigation>goodnight</navigation>',
				'expectedOutput' => false
			],
			[
				'string' => '<navigation>null</navigation>',
				'expectedOutput' => false
			],
			[
				'string' => '<navigation>0</navigation>',
				'expectedOutput' => false
			],
			[
				'string' => '<navigation>\'0\'</navigation>',
				'expectedOutput' => false
			],
			[
				'string' => '<navigation></navigation>',
				'expectedOutput' => true
			],
			[
				'string' => '<navigation>    </navigation>',
				'expectedOutput' => true
			]
		];
	}
}
