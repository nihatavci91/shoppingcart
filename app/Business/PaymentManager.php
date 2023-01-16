<?php
namespace App\Business;

use App\Models\Payment;
use App\Repository\PaymentRepository;

class PaymentManager
{
    protected PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param array $request
     * @return Payment
     */
    public function create(array $request): Payment
    {
        $data['user_id'] = $request['user_id'];
        $data['mdStatus'] = $request['mdStatus'];
        $data['conversationId'] = $request['conversationId'];
        $data['payment_id'] = $request['paymentId'];

        return $this->paymentRepository->create($data);
    }
}
