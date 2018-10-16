<?php declare(strict_types=1);
/*
 * This file is part of the feed-io package.
 *
 * (c) Alexandre Debril <alex.debril@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeedIo\Rule;

use FeedIo\DateRuleAbstract;
use FeedIo\Feed\NodeInterface;

class Published extends DateRuleAbstract
{
    const NODE_NAME = 'pubDate';

    /**
     * Sets the accurate $item property according to the DomElement content
     *
     * @param  NodeInterface $node
     * @param  \DOMElement   $element
     */
    public function setProperty(NodeInterface $node, \DOMElement $element) : void
    {
        $node->setPublished($this->getDateTimeBuilder()->convertToDateTime($element->nodeValue));
    }

    /**
     * Tells if the node contains the expected value
     *
     * @param NodeInterface $node
     * @return bool
     */
    protected function hasValue(NodeInterface $node) : bool
    {
        return !! $node->getPublished();
    }

    /**
     * Creates and adds the element(s) to the docuement's rootElement
     *
     * @param \DomDocument $document
     * @param \DOMElement $rootElement
     * @param NodeInterface $node
     */
    protected function addElement(\DomDocument $document, \DOMElement $rootElement, NodeInterface $node) : void
    {
        $date = is_null($node->getPublished()) ? $node->getLastModified():$node->getPublished();

        $rootElement->appendChild($document->createElement(
            $this->getNodeName(),
            $date->format($this->getDefaultFormat())
        ));
    }
}
