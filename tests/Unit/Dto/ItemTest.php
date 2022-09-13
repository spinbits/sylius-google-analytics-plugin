<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Spinbits\SyliusGoogleAnalytics4Plugin\Unit\Dto;

use Spinbits\SyliusGoogleAnalytics4Plugin\Dto\Item\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    private Item $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new Item(
            'Id',
            'Name',
            5.59,
            'USD',
            0.1,
            2,
            'aff',
            'COUPON_NAME',
            2,
            'Brand name',
            ['categoryA', 'categoryB','categoryC','categoryD','categoryE','skipped category'],
            'list_id',
            'list_name',
            'variant',
            'location',
        );
    }

    public function testValue()
    {
        $this->assertSame(10.98, $this->sut->getValue());
    }

    public function testSerialize()
    {
        $result = json_encode($this->sut);

        $this->assertSame('{"item_id":"Id","item_name":"Name","affiliation":"aff","coupon":"COUPON_NAME","currency":"USD","discount":0.1,"index":2,"item_brand":"Brand name","item_category":"categoryA","item_category2":"categoryB","item_category3":"categoryC","item_category4":"categoryD","item_category5":"categoryE","item_list_id":"list_id","item_list_name":"list_name","item_variant":"variant","location_id":"location","price":5.59,"quantity":2}', $result);
    }

    public function testSetters()
    {
        $this->sut
            ->setPrice(3.51)
            ->setQuantity(3)
            ->setAffiliation('new_aff')
            ->setCoupon('c1')
            ->setDiscount(0.5)
            ->setIndex(3)
            ->setItemBrand('newBrand')
            ->setItemListId('id')
            ->setItemListName('name')
            ->setItemVariant('var')
            ->setLocationId('loc');

        $result = json_encode($this->sut);

        $this->assertSame('{"item_id":"Id","item_name":"Name","affiliation":"new_aff","coupon":"c1","currency":"USD","discount":0.5,"index":3,"item_brand":"newBrand","item_category":"categoryA","item_category2":"categoryB","item_category3":"categoryC","item_category4":"categoryD","item_category5":"categoryE","item_list_id":"id","item_list_name":"name","item_variant":"var","location_id":"loc","price":3.51,"quantity":3}', $result);
    }
}
