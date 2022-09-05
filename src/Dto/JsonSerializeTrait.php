<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\Dto;

trait JsonSerializeTrait
{
    /**
     * @psalm-suppress MixedAssignment
     */
    public function jsonSerialize(): mixed
    {
        $result = [];
        /** @var mixed $value */
        foreach (get_object_vars($this) as $key => $value) {
            if ($value instanceof \JsonSerializable) {
                $result[$key] = $value->jsonSerialize();
            } elseif (null !== $value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
