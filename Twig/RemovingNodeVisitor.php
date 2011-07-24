<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\TranslationBundle\Twig;

/**
 * Removes translation metadata filters from the AST.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class RemovingNodeVisitor implements \Twig_NodeVisitorInterface
{
    private $enabled = true;

    public function setEnabled($bool)
    {
        $this->enabled = (Boolean) $bool;
    }

    public function enterNode(\Twig_NodeInterface $node, \Twig_Environment $env)
    {
        if ($this->enabled && $node instanceof \Twig_Node_Expression_Filter) {
            $name = $node->getNode('filter')->getAttribute('value');

            if ('desc' === $name || 'meaning' === $name) {
                return $node->getNode('node');
            }
        }

        return $node;
    }

    public function leaveNode(\Twig_NodeInterface $node, \Twig_Environment $env)
    {
        return $node;
    }

    public function getPriority()
    {
        return 256;
    }
}