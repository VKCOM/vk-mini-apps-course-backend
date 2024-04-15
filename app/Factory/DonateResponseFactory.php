<?php

declare(strict_types=1);

namespace App\Factory;

use App\Components\Donate\IncorrectSignException;
use App\Components\Donate\DonatePaymentService;
use App\Dto\DonateOrderInfo;
use App\Dto\DonateOrderResult;
use App\Enums\DonatePaymentNotificationTypeEnum;
use App\Enums\UserNotificationStatusEnum;
use App\Http\Requests\DonateRequest;
use App\Http\Resources\Donate\DonateErrorResource;
use App\Http\Resources\Donate\DonateItemResource;
use App\Http\Resources\Donate\DonateSuccessOrderResource;
use App\Http\Resources\Donate\DonateSuccessSubscriptionResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

final class DonateResponseFactory
{
    private const SIGNE_ERROR_CODE = 10;
    private const SERVER_ERROR = 2;

    public function __construct(private readonly DonatePaymentService $votePaymentService)
    {
    }

    public function create(DonateRequest $request): JsonResource
    {
        try {
            $result = $this->votePaymentService->process($request);
        } catch (IncorrectSignException $exception) {
            Log::error('Error during process payment: incorrect sign', [
                'exception' => $exception->getMessage(),
                'request' => $request->toArray(),
            ]);

            return new DonateErrorResource(errorCode: self::SIGNE_ERROR_CODE, isCritical: true);
        } catch (\Throwable $exception) {
            Log::error('Error during process payment', [
                'exception' => $exception->getMessage(),
                'request' => $request->toArray(),
            ]);

            return new DonateErrorResource(errorCode: self::SERVER_ERROR);
        }

        if ($result instanceof DonateOrderInfo) {
            return new DonateItemResource($result);
        }
        $notificationType = DonatePaymentNotificationTypeEnum::from($request->get('notification_type'));
        if ($notificationType === DonatePaymentNotificationTypeEnum::ORDER_SUBSCRIPTION_CHANGE
            || $notificationType === DonatePaymentNotificationTypeEnum::ORDER_SUBSCRIPTION_CHANGE_TEST
        ) {
            return new DonateSuccessSubscriptionResource(
                orderId: $result->getExternalOrderId(),
                appOrderId: $result->getInternalOrderId(),
            );
        }
        return new DonateSuccessOrderResource(
            orderId: $result->getExternalOrderId(),
            appOrderId: $result->getInternalOrderId(),
        );
    }
}
