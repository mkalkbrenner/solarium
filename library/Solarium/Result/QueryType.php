<?php
/**
 * Copyright 2011 Bas de Nooijer. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this listof conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDER AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * The views and conclusions contained in the software and documentation are
 * those of the authors and should not be interpreted as representing official
 * policies, either expressed or implied, of the copyright holder.
 *
 * @copyright Copyright 2011 Bas de Nooijer <solarium@raspberry.nl>
 * @license http://github.com/basdenooijer/solarium/raw/master/COPYING
 *
 * @package Solarium
 * @subpackage Result
 */

/**
 * QueryType result
 *
 * @package Solarium
 * @subpackage Result
 */
class Solarium_Result_QueryType extends Solarium_Result
{

    /**
     * Lazy load parsing indicator
     *
     * @var bool
     */
    protected $_parsed = false;

    /**
     * Parse response into result objects
     *
     * Only runs once
     * 
     * @return void
     */
    protected function _parseResponse()
    {
        if (!$this->_parsed) {
            $queryType = $this->_query->getType();
            $queryTypes = $this->_client->getQueryTypes();
            if (!isset($queryTypes[$queryType])) {
                throw new Solarium_Exception('No responseparser registered for querytype: '. $queryType);
            }

            $responseParserClass = $queryTypes[$queryType]['responseparser'];
            $responseParser = new $responseParserClass;
            $this->_mapData($responseParser->parse($this));

            $this->_parsed = true;
        }
    }

    /**
     * Map parser data into properties
     *
     * @param array $mapData
     * @return void
     */
    protected function _mapData($mapData)
    {
        foreach ($mapData AS $key => $data) {
            $this->{'_'.$key} = $data;
        }
    }
    
}