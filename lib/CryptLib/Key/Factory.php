<?php
/**
 * The core Key Factory
 *
 * PHP version 5.3
 *
 * @category   PHPCryptLib
 * @package    Key
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @license    http://www.gnu.org/licenses/lgpl-2.1.html LGPL v 2.1
 */

namespace CryptLib\Key;

/**
 * The core Key Factory
 *
 * @category   PHPCryptLib
 * @package    Key
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 */
class Factory extends \CryptLib\Core\AbstractFactory {

    /**
     * @var array An array of KDF class implementations
     */
    protected $kdf                 = array();

    /**
     * @var array An array of PBKDF class implementations
     */
    protected $pbkdf               = array();

    /**
     * @var array An array of symmetric key generator implementations
     */
    protected $symmetricGenerators = array();

    /**
     * Construct the instance, loading the core implementations
     *
     * @return void
     */
    public function __construct() {
        $this->loadPBKDF();
        //$this->loadKDF();
        //$this->loadSymmetricGenerators();
    }

    public function getKDF($name = 'kdf3', array $options = array()) {
        if (isset($this->kdf[$name])) {
            $class = $this->kdf[$name];
            return new $class($options);
        }
        throw new \InvalidArgumentException('Unsupported KDF');
    }

    public function getPBKDF($name = 'pbkdf2', array $options = array()) {
        if (isset($this->pbkdf[$name])) {
            $class = $this->pbkdf[$name];
            return new $class($options);
        }
        throw new \InvalidArgumentException('Unsupported PBKDF');
    }

    public function getSymmetricKeyGenerator() {
    }

    public function registerKDF($name, $class) {
        $this->registerType(
            'kdf',
            __NAMESPACE__ . '\\Derivation\\KDF',
            $name,
            $class
        );
    }

    public function registerPBKDF($name, $class) {
        $this->registerType(
            'pbkdf',
            __NAMESPACE__ . '\\Derivation\\PBKDF',
            $name,
            $class
        );
    }

    protected function loadKDF() {
        $this->loadFiles(
            __DIR__ . '/derivation/kdf',
            __NAMESPACE__ . '\\Derivation\\KDF\\',
            'registerKDF'
        );
    }

    protected function loadPBKDF() {
        $this->loadFiles(
            __DIR__ . '/derivation/pbkdf',
            __NAMESPACE__ . '\\Derivation\\PBKDF\\',
            'registerPBKDF'
        );
    }

}
