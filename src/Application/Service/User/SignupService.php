<?php

namespace App\Application\Service\User;

use App\Domain\User\User;
use App\Domain\User\UserRepository;
//use App\Domain\DomainEventPublisher;
use App\Domain\User\UserAlreadyExistsException;
use Ddd\Application\Service\ApplicationService;
use App\Application\Transformer\User\UserTransformer;

class SignupService implements ApplicationService
{
    /**
     * @var AuthenticatorInterface
     */
    protected $userRepository;
    private $dataTransformer;

    public function __construct(
        UserRepository $userRepository,
        UserTransformer $dataTransformer
    ) {
        $this->userRepository = $userRepository;
        $this->dataTransformer = $dataTransformer;
    }

    /**
     * @param SignUpUserRequest $request
     *
     * @return User
     *
     * @throws UserAlreadyExistsException
     *
     * @codeCoverageIgnore
     */
    public function execute($request = null)
    {
        $name = $request->name();
        $email = $request->email();
        $password = $request->password();

        $user = $this->userRepository->ofEmail($email);
        if (null !== $user) {
            throw new UserAlreadyExistsException();
        }

        $user = User::draft($name, $email, $password);

        $this->userRepository->add($user);

        $this->dataTransformer->write($user);

        return $this->dataTransformer->read();
    }
}
