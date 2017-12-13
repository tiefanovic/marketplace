<?php
namespace AWstreams\Marketplace\Plugin\Customer;
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/13/17
 * Time: 5:32 PM
 */
use AWstreams\Marketplace\Setup\InstallData;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;

class Vendor
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var array
     */
    private $allowedActions = [];

    /**
     * @param Session $customerSession
     * @param array $allowedActions List of actions that are allowed for not authorized users
     */
    public function __construct(
        Session $customerSession,
        array $allowedActions = []
    ) {
        $this->session = $customerSession;
        $this->allowedActions = $allowedActions;
    }

    /**
     * Dispatch actions allowed for not authorized users
     *
     * @param ActionInterface $subject
     * @param \Closure $proceed
     * @param RequestInterface $request
     * @return mixed
     */
    public function aroundDispatch(
        ActionInterface $subject,
        \Closure $proceed,
        RequestInterface $request
    ) {
        $action = strtolower($request->getActionName());
        $pattern = '/^(' . implode('|', $this->allowedActions) . ')$/i';

        if (!preg_match($pattern, $action)) {
            if (!$this->session->authenticate() || !$this->session->getCustomer()->getData(InstallData::APPROVED_ACCOUNT)) {
                $subject->getActionFlag()->set('', ActionInterface::FLAG_NO_DISPATCH, true);
            }
        } else {
            $this->session->setNoReferer(true);
        }

        $result = $proceed($request);
        $this->session->unsNoReferer(false);
        return $result;
    }
}