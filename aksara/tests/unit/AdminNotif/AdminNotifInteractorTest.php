<?php

use Faker\Factory as Faker;
use Aksara\AdminNotif\Interactor;
use Aksara\AdminNotif\AdminNotifRequest;
use Aksara\Repository\SessionRepository;

class AdminNotifInteractorTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldAppendNotice()
    {
        $request = $this->getMockBuilder(AdminNotifRequest::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->once())
            ->method('toArray')
            ->willReturn($notice = $this->faker->words);

        $sessionRepo = $this->getMockBuilder(SessionRepository::class)
            ->getMock();

        $sessionRepo->expects($this->once())
            ->method('has')
            ->with('admin_notice')
            ->willReturn(true);

        $existing = [ $this->faker->words ];

        $sessionRepo->expects($this->once())
            ->method('get')
            ->with('admin_notice')
            ->willReturn($existing);

        $sessionRepo->expects($this->once())
            ->method('flash')
            ->with('admin_notice', array_merge($existing, [ $notice ]));

        $interactor = new Interactor($sessionRepo);

        $interactor->handle($request);
    }

    /** @test */
    public function shouldNewNotice()
    {
        $request = $this->getMockBuilder(AdminNotifRequest::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->once())
            ->method('toArray')
            ->willReturn($notice = $this->faker->words);

        $sessionRepo = $this->getMockBuilder(SessionRepository::class)
            ->getMock();

        $sessionRepo->expects($this->once())
            ->method('has')
            ->with('admin_notice')
            ->willReturn(false);

        $sessionRepo->expects($this->once())
            ->method('flash')
            ->with('admin_notice', [ $notice ]);

        $interactor = new Interactor($sessionRepo);

        $interactor->handle($request);
    }
}
