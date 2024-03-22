<?php

declare(strict_types = 1);

namespace NineteenEightyFour\NineteenEightyWoo\Model\Order;

use JsonSerializable;
use stdClass;

/**
 * The OrderLine DTO class for DK
 */
class OrderLine implements JsonSerializable {
	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var int $SequenceNumber
	 */
	protected int $SequenceNumber = 0;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string $ItemCode
	 */
	protected string $ItemCode;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $Text
	 */
	protected string|null $Text;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $Text2
	 */
	protected string|null $Text2;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $Warehouse
	 */
	protected string|null $Warehouse;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $Location
	 */
	protected string|null $Location;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var float $Quantity
	 */
	protected float $Quantity = 0;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var float $QuantityDelivered
	 */
	protected float $QuantityDelivered = 0;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var float $UnitPrice
	 */
	protected float $UnitPrice;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var float $UnitPriceWithTax
	 */
	protected float $UnitPriceWithTax;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $UnitCode
	 */
	protected string|null $UnitCode;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var float $Discount
	 */
	protected float $Discount = 0;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var float $DiscountPercent
	 */
	protected float $DiscountPercent = 0;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var float $TotalAmount
	 */
	protected float $TotalAmount = 0;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var float $TotalAmountWithTax
	 */
	protected float $TotalAmountWithTax = 0;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $BarCode
	 */
	protected string|null $BarCode;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $Reference
	 */
	protected string|null $Reference;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $EDIOrderNumber
	 */
	protected string|null $EDIOrderNumber;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var int $UNDOrderNumber
	 */
	protected int $UNDOrderNumber = 0;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var string|null $Memo
	 */
	protected string|null $Memo;

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 *
	 * @var array $Variations
	 */
	protected array $Variations = [];

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function createOrderLineFromDKData( stdClass $OrderLine ): void {
		$this->setSequenceNumber( $OrderLine->SequenceNumber ?? 0 );
		$this->setItemCode( $OrderLine->ItemCode );
		$this->setText( $OrderLine->Text ?? null );
		$this->setText2( $OrderLine->Text2 ?? null );
		$this->setWarehouse( $OrderLine->Warehouse ?? null );
		$this->setLocation( $OrderLine->Location ?? null );
		$this->setQuantity( $OrderLine->Quantity ?? 0 );
		$this->setQuantityDelivered( $OrderLine->QuantityDelivered ?? 0 );
		$this->setUnitPrice( $OrderLine->UnitPrice ?? 0 );
		$this->setUnitPriceWithTax( $OrderLine->UnitPriceWithTax ?? 0 );
		$this->setUnitCode( $OrderLine->UnitCode ?? null );
		$this->setDiscount( $OrderLine->Discount ?? 0 );
		$this->setDiscountPercent( $OrderLine->DiscountPercent ?? 0 );
		$this->setTotalAmount( $OrderLine->TotalAmount ?? 0 );
		$this->setTotalAmountWithTax( $OrderLine->TotalAmountWithTax ?? 0 );
		$this->setBarCode( $OrderLine->BarCode ?? null );
		$this->setReference( $OrderLine->Reference ?? null );
		$this->setEDIOrderNumber( $OrderLine->EDIOrderNumber ?? null );
		$this->setUNDOrderNumber( $OrderLine->UNDOrderNumber ?? 0 );
		$this->setVariations( $OrderLine->Variations ?? [] );
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getSequenceNumber(): int {
		return $this->SequenceNumber;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setSequenceNumber( int $SequenceNumber ): OrderLine {
		$this->SequenceNumber = $SequenceNumber;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getItemCode(): string {
		return $this->ItemCode;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setItemCode( string $ItemCode ): OrderLine {
		$this->ItemCode = $ItemCode;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getText(): ?string {
		return $this->Text;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setText( ?string $Text ): OrderLine {
		$this->Text = $Text;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getText2(): ?string {
		return $this->Text2;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setText2( ?string $Text2 ): OrderLine {
		$this->Text2 = $Text2;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getWarehouse(): ?string {
		return $this->Warehouse;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setWarehouse( ?string $Warehouse ): OrderLine {
		$this->Warehouse = $Warehouse;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getLocation(): ?string {
		return $this->Location;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setLocation( ?string $Location ): OrderLine {
		$this->Location = $Location;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getQuantity(): float {
		return $this->Quantity;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setQuantity( float $Quantity ): OrderLine {
		$this->Quantity = $Quantity;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getQuantityDelivered(): float {
		return $this->QuantityDelivered;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setQuantityDelivered( float $QuantityDelivered ): OrderLine {
		$this->QuantityDelivered = $QuantityDelivered;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getUnitPrice(): float {
		return $this->UnitPrice;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setUnitPrice( float $UnitPrice ): OrderLine {
		$this->UnitPrice = $UnitPrice;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getUnitPriceWithTax(): float {
		return $this->UnitPriceWithTax;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setUnitPriceWithTax( float $UnitPriceWithTax ): OrderLine {
		$this->UnitPriceWithTax = $UnitPriceWithTax;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getUnitCode(): ?string {
		return $this->UnitCode;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setUnitCode( ?string $UnitCode ): OrderLine {
		$this->UnitCode = $UnitCode;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getDiscount(): float {
		return $this->Discount;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setDiscount( float $Discount ): OrderLine {
		$this->Discount = $Discount;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getDiscountPercent(): float {
		return $this->DiscountPercent;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setDiscountPercent( float $DiscountPercent ): OrderLine {
		$this->DiscountPercent = $DiscountPercent;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getTotalAmount(): float {
		return $this->TotalAmount;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setTotalAmount( float $TotalAmount ): OrderLine {
		$this->TotalAmount = $TotalAmount;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getTotalAmountWithTax(): float {
		return $this->TotalAmountWithTax;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setTotalAmountWithTax( float $TotalAmountWithTax ): OrderLine {
		$this->TotalAmountWithTax = $TotalAmountWithTax;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getBarCode(): ?string {
		return $this->BarCode;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setBarCode( ?string $BarCode ): OrderLine {
		$this->BarCode = $BarCode;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getReference(): ?string {
		return $this->Reference;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setReference( ?string $Reference ): OrderLine {
		$this->Reference = $Reference;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getEDIOrderNumber(): ?string {
		return $this->EDIOrderNumber;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setEDIOrderNumber( ?string $EDIOrderNumber ): OrderLine {
		$this->EDIOrderNumber = $EDIOrderNumber;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getUNDOrderNumber(): int {
		return $this->UNDOrderNumber;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setUNDOrderNumber( int $UNDOrderNumber ): OrderLine {
		$this->UNDOrderNumber = $UNDOrderNumber;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getMemo(): ?string {
		return $this->Memo;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setMemo( ?string $Memo ): OrderLine {
		$this->Memo = $Memo;
		return $this;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function getVariations(): array {
		return $this->Variations;
	}

	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function setVariations( array $Variations ): OrderLine {
		foreach ( $Variations as $variation ) {
			$obj = new VariationModel();
			$obj->createVariationModelFromDKData( $variation );
			$this->Variations[] = $obj;
		}
		return $this;
	}


	/**
	 * Short description (CS requirement, unnecessary for DTO Class)
	 */
	public function jsonSerialize(): string {
		return json_encode( get_object_vars( $this ) );
	}
}