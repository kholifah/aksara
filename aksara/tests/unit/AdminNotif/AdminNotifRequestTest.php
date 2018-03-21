<?php

use Faker\Factory as Faker;
use Aksara\AdminNotif\AdminNotifRequest;

class AdminNotifRequestTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldCreateRequest()
    {
        $request = new AdminNotifRequest(
            $labelClass = $this->faker->word,
            $content = $this->faker->sentence
        );

        $this->assertEquals($labelClass, $request->getLabelClass());
        $this->assertEquals($content, $request->getContent());

        $array = $request->toArray();

        $this->assertEquals($labelClass, $array['labelClass']);
        $this->assertEquals($content, $array['content']);

    }
}
