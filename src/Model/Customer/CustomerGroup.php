<?php

declare(strict_types = 1);

namespace NineteenEightyFour\NineteenEightyWoo\Model\Customer;

use JsonSerializable;
use stdClass;

/**
 * The CustomerGroup DTO class for DK
 */
class CustomerGroup implements JsonSerializable {
	/**
	 * @var string|null $Modified
	 */
	protected ?string $Modified;

	/**
	 * @var int $ID
	 */
	protected int $ID = 0;

	/**
	 * @var string|null $Number
	 */
	protected ?string $Number;

	/**
	 * @var string|null $Description
	 */
	protected ?string $Description;

	/**
	 * @return $this
	 */
	public function createCustomerGroupFromDKData( stdClass $customer_group ): CustomerGroup {
		$this->setModified( $customer_group->Modified ?? null );
		$this->setID( $customer_group->ID ?? 0 );
		$this->setNumber( $customer_group->Number ?? null );
		$this->setDescription( $customer_group->Description ?? null );
		return $this;
	}

	public function getModified(): ?string {
		return $this->Modified;
	}

	/**
	 * @return $this
	 */
	public function setModified( ?string $Modified ): CustomerGroup {
		$this->Modified = $Modified;
		return $this;
	}

	public function getID(): int {
		return $this->ID;
	}

	/**
	 * @return $this
	 */
	public function setID( int $ID ): CustomerGroup {
		$this->ID = $ID;
		return $this;
	}

	public function getNumber(): ?string {
		return $this->Number;
	}

	/**
	 * @return $this
	 */
	public function setNumber( ?string $Number ): CustomerGroup {
		$this->Number = $Number;
		return $this;
	}

	public function getDescription(): ?string {
		return $this->Description;
	}

	/**
	 * @return $this
	 */
	public function setDescription( ?string $Description ): CustomerGroup {
		$this->Description = $Description;
		return $this;
	}

	public function jsonSerialize(): string {
		return json_encode( get_object_vars( $this ) );
	}
}
