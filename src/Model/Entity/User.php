<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property int $enterprise_id
 * @property string $employee_id
 * @property string $last_name
 * @property string $first_name
 * @property string $last_name_kana
 * @property string $first_name_kana
 * @property string $phone_number
 * @property string $email
 * @property bool $gender
 * @property \Cake\I18n\FrozenDate $birthday
 * @property string $postalcode
 * @property int $prefecture_id
 * @property string $city
 * @property string $block
 * @property string|null $building
 * @property int $role
 * @property string $password
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 * @property \Cake\I18n\FrozenTime|null $deleted_at
 *
 * @property \App\Model\Entity\Enterprise $enterprise
 * @property \App\Model\Entity\Prefecture $prefecture
 * @property \App\Model\Entity\Punch[] $punches
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'enterprise_id' => true,
        'employee_id' => true,
        'last_name' => true,
        'first_name' => true,
        'last_name_kana' => true,
        'first_name_kana' => true,
        'phone_number' => true,
        'email' => true,
        'gender' => true,
        'birthday' => true,
        'postalcode' => true,
        'prefecture_id' => true,
        'city' => true,
        'block' => true,
        'building' => true,
        'role' => true,
        'password' => true,
        'created_at' => true,
        'modified_at' => true,
        'deleted_at' => true,
        'enterprise' => true,
        'prefecture' => true,
        'punches' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];

    
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
    // ↓ これを追加
    protected function _getIsAdmin()
    {
        return $this->role === 2;
    }
}
