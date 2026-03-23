<?php

namespace App\Controller\Api;

use App\Entity\SoftwareVersion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/carplay/software', name: 'api_carplay_firmware_download')]
class ConnectedSiteController extends AbstractController
{
    #[Route('/version', name: 'version', methods: ['POST','GET'])]
    public function softwareDownload(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $version = $_REQUEST['version'];
        $hwVersion = $_REQUEST['hwVersion'] ?? null;
        $mcuVersion = $_REQUEST['mcuVersion'] ?? null;

        // Validate required fields
        if (!$version) {
            return new JsonResponse(['msg' => 'Version is required'], 200);
        }

        // Define regex patterns for different hardware types
        $patternST = '/^CPAA_[0-9]{4}\.[0-9]{2}\.[0-9]{2}(_[A-Z]+)?$/i';
        $patternGD = '/^CPAA_G_[0-9]{4}\.[0-9]{2}\.[0-9]{2}(_[A-Z]+)?$/i';
        $patternLCI_CIC = '/^B_C_[0-9]{4}\.[0-9]{2}\.[0-9]{2}$/i';
        $patternLCI_NBT = '/^B_N_G_[0-9]{4}\.[0-9]{2}\.[0-9]{2}$/i';
        $patternLCI_EVO = '/^B_E_G_[0-9]{4}\.[0-9]{2}\.[0-9]{2}$/i';

        $hwVersionBool = false;
        $stBool = false;
        $gdBool = false;
        $isLCI = false;
        $lciHwType = '';

        if (preg_match($patternST, $hwVersion)) { $hwVersionBool = true; $stBool = true; }
        if (preg_match($patternGD, $hwVersion)) { $hwVersionBool = true; $gdBool = true; }
        if (preg_match($patternLCI_CIC, $hwVersion)) { $hwVersionBool = true; $isLCI = true; $lciHwType = 'CIC'; $stBool = true; }
        if (preg_match($patternLCI_NBT, $hwVersion)) { $hwVersionBool = true; $isLCI = true; $lciHwType = 'NBT'; $gdBool = true; }
        if (preg_match($patternLCI_EVO, $hwVersion)) { $hwVersionBool = true; $isLCI = true; $lciHwType = 'EVO'; $gdBool = true; }

        if (!$hwVersionBool) {
            return new JsonResponse(['msg' => 'There was a problem identifying your software. Contact us for help.'], 200);
        }

        // Normalize version (remove leading 'v' or 'V')
        if (str_starts_with($version, 'v') || str_starts_with($version, 'V')) {
            $version = substr($version, 1);
        }

        // Fetch software versions from DB
        $repo = $em->getRepository(SoftwareVersion::class);
        $softwareVersions = $repo->findAll();

        $response = [];

        foreach ($softwareVersions as $row) {
            if (strcasecmp($row->getSystemVersionAlt(), $version) === 0) {
                $isLCIEntry = str_starts_with($row->getName(), 'LCI');

                if ($isLCI !== $isLCIEntry) continue;
                if ($isLCI && stripos($row->getName(), $lciHwType) === false) continue;

                if ($row->isLatest()) {
                    $response = [
                        'versionExist' => true,
                        'msg' => 'Your system is up to date!',
                        'link' => '',
                        'st' => '',
                        'gd' => '',
                    ];
                } else {
                    $response = [
                        'versionExist' => true,
                        'msg' => 'The latest version of software is ' . ($isLCI ? 'v3.4.4' : 'v3.3.7'),
                        'link' => $row->getLink(),
                        'st' => $stBool ? $row->getSt() : '',
                        'gd' => $gdBool ? $row->getGd() : '',
                    ];
                }
                break;
            }
        }

        if (!$response) {
            $response = [
                'versionExist' => false,
                'msg' => 'There was a problem identifying your software. Contact us for help.',
                'link' => '',
                'st' => '',
                'gd' => '',
            ];
        }

        return new JsonResponse($response, 200);
    }
}
