<?php
namespace Adyen\Payment\Block;

use Symfony\Component\Config\Definition\Exception\Exception;

class Validate3d extends \Magento\Payment\Block\Form
{

    protected $_orderFactory;
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    protected $_order;

    /**
     * Constructor
     *
     * @param \\Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = [],
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->_orderFactory = $orderFactory;
        $this->_checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
        $this->_getOrder();
    }


    /**
     * Get order object
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function _getOrder()
    {
        if (!$this->_order) {
            $incrementId = $this->_getCheckout()->getLastRealOrderId();
            $this->_order = $this->_orderFactory->create()->loadByIncrementId($incrementId);
        }
        return $this->_order;
    }

    /**
     * Get frontend checkout session object
     *
     * @return \Magento\Checkout\Model\Session
     */
    protected function _getCheckout()
    {
        return $this->_checkoutSession;
    }

    public function getIssuerUrl()
    {
        return $this->_order->getPayment()->getAdditionalInformation('issuerUrl');
    }

    public function getPaReq()
    {
        return $this->_order->getPayment()->getAdditionalInformation('paRequest');
    }

    public function getMd()
    {
        return $this->_order->getPayment()->getAdditionalInformation('md');
    }

    public function getTermUrl()
    {
        return  $this->getUrl('adyen/process/validate3d');
    }


}