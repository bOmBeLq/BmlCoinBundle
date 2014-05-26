<?php


namespace Bml\CoinBundle\Exception;

use Exception;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Exception
 */
class RequestException extends \RuntimeException
{
    // Standard JSON-RPC 2.0 errors
    const RPC_INVALID_REQUEST = -32600;

    const RPC_METHOD_NOT_FOUND = -32601;

    const RPC_INVALID_PARAMS = -32602;

    const RPC_INTERNAL_ERROR = -32603;

    const RPC_PARSE_ERROR = -32700;

    // General application defined errors
    const RPC_MISC_ERROR = -1; // std::exception thrown in command handling
    const RPC_FORBIDDEN_BY_SAFE_MODE = -2; // Server is in safe mode; and command is not allowed in safe mode
    const RPC_TYPE_ERROR = -3; // Unexpected type was passed as parameter
    const RPC_INVALID_ADDRESS_OR_KEY = -5; // Invalid address or key
    const RPC_OUT_OF_MEMORY = -7; // Ran out of memory during operation
    const RPC_INVALID_PARAMETER = -8; // Invalid; missing or duplicate parameter
    const RPC_DATABASE_ERROR = -20; // Database error
    const RPC_DESERIALIZATION_ERROR = -22; // Error parsing or validating structure in raw format
    const RPC_SERVER_NOT_STARTED = -18; // RPC server was not started (StartRPCThreads() not called)

    // P2P client errors
    const RPC_CLIENT_NOT_CONNECTED = -9; // Bitcoin is not connected
    const RPC_CLIENT_IN_INITIAL_DOWNLOAD = -10; // Still downloading initial blocks
    const RPC_CLIENT_NODE_ALREADY_ADDED = -23; // Node is already added
    const RPC_CLIENT_NODE_NOT_ADDED = -24; // Node has not been added before

    // Wallet errors
    const RPC_WALLET_ERROR = -4; // Unspecified problem with wallet (key not found etc.)
    const RPC_WALLET_INSUFFICIENT_FUNDS = -6; // Not enough funds in wallet or account
    const RPC_WALLET_INVALID_ACCOUNT_NAME = -11; // Invalid account name
    const RPC_WALLET_KEYPOOL_RAN_OUT = -12; // Keypool ran out; call keypoolrefill first
    const RPC_WALLET_UNLOCK_NEEDED = -13; // Enter the wallet passphrase with walletpassphrase first
    const RPC_WALLET_PASSPHRASE_INCORRECT = -14; // The wallet passphrase entered was incorrect
    const RPC_WALLET_WRONG_ENC_STATE = -15; // Command given in wrong wallet encryption state (encrypting an encrypted wallet etc.)
    const RPC_WALLET_ENCRYPTION_FAILED = -16; // Failed to encrypt the wallet
    const RPC_WALLET_ALREADY_UNLOCKED = -17; // Wallet is already unlocked


}
