<?php

/*
 * This file is part of the XabbuhPandaBundle package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\PandaBundle\Tests\Command;

use Symfony\Bridge\PhpUnit\SetUpTearDownTrait;
use Symfony\Component\Console\Command\Command;
use Xabbuh\PandaBundle\Command\VideoInfoCommand;
use Xabbuh\PandaClient\Model\Video;

/**
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class VideoInfoCommandTest extends CloudCommandTest
{
    use SetUpTearDownTrait;

    private function doSetUp()
    {
        $this->apiMethod = 'getVideo';

        parent::setUp();
    }

    public function testCommand()
    {
        $videoId = md5(uniqid());
        $video = new Video();
        $video->setId($videoId);
        $video->setOriginalFilename('foo.mp4');
        $video->setWidth(800);
        $video->setHeight(600);
        $video->setCreatedAt('2012/09/04 13:13:55 +0000');
        $video->setUpdatedAt('2013/01/22 22:36:53 +0000');
        $this->defaultCloud
            ->expects($this->once())
            ->method('getVideo')
            ->with($videoId)
            ->will($this->returnValue($video));
        $this->runCommand('panda:video:info', array('video-id' => $videoId));
        $this->validateTableRows(array(
            array('id', $videoId),
            array('file name', 'foo.mp4'),
            array('width', '800'),
            array('height', '600'),
            array('created at', '2012/09/04 13:13:55 +0000'),
            array('updated at', '2013/01/22 22:36:53 +0000'),
        ));
    }

    public function testCommandWithFailedEncoding()
    {
        $videoId = md5(uniqid());
        $video = new Video();
        $video->setId($videoId);
        $video->setOriginalFilename('foo.mp4');
        $video->setWidth(800);
        $video->setHeight(600);
        $video->setStatus('fail');
        $video->setErrorMessage('Encoding failed');
        $video->setCreatedAt('2012/09/04 13:13:55 +0000');
        $video->setUpdatedAt('2013/01/22 22:36:53 +0000');
        $this->defaultCloud
            ->expects($this->once())
            ->method('getVideo')
            ->with($videoId)
            ->will($this->returnValue($video));
        $this->runCommand('panda:video:info', array('video-id' => $videoId));
        $this->validateTableRows(array(
            array('id', $videoId),
            array('file name', 'foo.mp4'),
            array('width', '800'),
            array('height', '600'),
            array('error message', 'Encoding failed'),
            array('created at', '2012/09/04 13:13:55 +0000'),
            array('updated at', '2013/01/22 22:36:53 +0000'),
        ));
    }

    public function testCommandWithoutArguments()
    {
        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage('Not enough arguments');

        $this->runCommand('panda:video:info');
    }

    protected function createCommand(): Command
    {
        return new VideoInfoCommand($this->cloudManager);
    }

    protected function getDefaultCommandArguments()
    {
        return array('video-id' => md5(uniqid()));
    }
}
