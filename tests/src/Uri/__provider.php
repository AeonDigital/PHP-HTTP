<?php





function provider_PHPHTTPURI_InstanceOf_Url($uri)
{
    return \AeonDigital\Http\Uri\Url::fromString($uri);
}
