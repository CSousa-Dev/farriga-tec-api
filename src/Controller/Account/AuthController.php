<?php 
namespace App\Controller\Account;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Infra\Doctrine\Entity\Security\ApiToken;
use App\Infra\Doctrine\Entity\Security\UserSecurityInfo;
use App\Infra\Doctrine\Repository\Security\ApiTokenRepository;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Infra\Doctrine\Repository\Security\UserSecurityInfoRepository;

class AuthController extends AbstractController
{
    #[Route('account/login', name: 'login', methods: ['POST'])]
    public function index(#[CurrentUser] UserSecurityInfo $userSecurityInfo, UserSecurityInfoRepository $userSecurityInfoRepository, Request $request): Response
    {
        if (null === $userSecurityInfo) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }


        if(!$request->getPayload()->has('appKey')) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }        

        $appKey = $request->getPayload()->get('appKey');
        $userSecurityInfoRepository->revokeAllTokens($userSecurityInfo);

        $token = new ApiToken($appKey); 
        $userWithToken = $userSecurityInfoRepository->addApiToken($userSecurityInfo, $token);

        $domainUser = $userWithToken->getDomainUser();

        // if($domainUser->getEmail()->getValidatedAt() === null) {
        //     throw new NotConfirmedEmailException(token: $token->getToken());
        // }

        return $this->json([
            'user'  => $userWithToken->getUserIdentifier(),
            'token' => $token->getToken(),
            'refreshToken' => $token->getRefreshToken(),
        ]);
    }

    #[Route('account/logout', name: 'logout', methods: ['POST'])]
    public function logout(#[CurrentUser] UserSecurityInfo $userSecurityInfo, UserSecurityInfoRepository $userSecurityInfoRepository): Response
    {
        if (null === $userSecurityInfo) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $userSecurityInfoRepository->removeApiToken($userSecurityInfo);

        return $this->json([
            'message' => 'logged out',
        ]);
    }

    #[Route('account/refresh', name: 'refresh', methods: ['POST'])]
    public function refresh(Request $request, ApiTokenRepository $apiTokenRepository, UserSecurityInfoRepository $userSecurityInfoRepository): Response
    {
        $refreshToken = $request->getPayload()->get('refreshToken');
        $appKey = $request->getPayload()->get('appKey');

        $bearerToken = $request->headers->get('Authorization');

        /**
         * @var ApiToken $apiToken
         */
        $apiToken = $apiTokenRepository->findOneByRefreshToken($refreshToken);

        if(null === $apiToken || $apiToken->isRefreshTokenRevoked()) {
            return $this->json([
                'message' => 'invalid token or refresh revoked, do login again.',
                'code' => 'refresh_token_invalid'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if($appKey !== $apiToken->getAppKey() || $bearerToken !== $apiToken->getToken()) {
            return $this->json([
                'message' => 'invalid credentials.',
                'code' => 'invalid_credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if($apiToken->getRefreshTokenExpiresAt() < new \DateTimeImmutable()) {
            return $this->json([
                'message' => 'refresh token expired, do login again.',
                'code' => 'refresh_token_expired'
            ], Response::HTTP_UNAUTHORIZED);
        }

       
        $tokenOwner = $apiToken->getOwnedBy();
        $tokenOwner->revokeAllTokens();

        $token = new ApiToken($appKey);
        $userWithToken = $userSecurityInfoRepository->addApiToken($tokenOwner, $token);

        return $this->json([
            'user'  => $userWithToken->getUserIdentifier(),
            'token' => $token->getToken(),
            'refreshToken' => $token->getRefreshToken(),
        ]);
    }
}