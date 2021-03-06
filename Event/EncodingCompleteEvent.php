<?php

/*
 * This file is part of the XabbuhPandaBundle package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\PandaBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Event that is triggered when an encoding has successfully finished.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class EncodingCompleteEvent extends Event
{
    /**
     * The ENCODING_COMPLETE event occurs when an encoding is done or failed.
     *
     * The event listener method receives a Xabbuh\PandaBundle\Event\EncodingCompleteEvent instance.
     */
    const NAME = 'xabbuh_panda.encoding_complete';

    /**
     * The id of the encoded video
     * @var string
     */
    private $videoId;

    /**
     * The id of the encoding
     * @var string
     */
    private $encodingId;

    /**
     * Constructs a new EncodingCompleteEvent.
     *
     * @param string $videoId    Video id
     * @param string $encodingId Encoding id
     */
    public function __construct($videoId, $encodingId)
    {
        $this->videoId = $videoId;
        $this->encodingId = $encodingId;
    }

    /**
     * Returns the video id.
     *
     * @return string The video id
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Returns the encoding id.
     *
     * @return string The encoding id
     */
    public function getEncodingId()
    {
        return $this->encodingId;
    }
}
