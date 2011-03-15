<?php
/**
 * An implementation of the RFC 10833-2 KDF2 Standard key derivation function
 *
 * PHP version 5.3
 *
 * @category   PHPCryptLib
 * @package    Key
 * @subpackage Derivation
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @license    http://www.gnu.org/licenses/lgpl-2.1.html LGPL v 2.1
 */

namespace CryptLib\Key\Derivation\KDF;

/**
 * An implementation of the RFC 10833-2 KDF2 Standard key derivation function
 *
 * @category   PHPCryptLib
 * @package    Key
 * @subpackage Derivation
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 */
class KDF2
    extends \CryptLib\Key\Derivation\AbstractDerivation
    implements \CryptLib\Key\Derivation\KDF
{

    /**
     * Derive a key of the specified length based on the inputted secret
     *
     * @param string $secret The secret to base the key on
     * @param int    $length The length of the key to derive
     * @param string $other  Additional data to append to the key
     *
     * @return string The generated key
     */
    public function derive($secret, $length, $other = '') {
        $size = $this->hash->getSize();
        $l    = ceil($length / $size);
        $t    = '';
        for ($i = 1; $i <= $l; $i++) {
            $p  = pack('N', $i);
            $t .= $this->hash->evaluate($secret . $p . $other);
        }
        return substr($t, 0, $length);
    }

}

