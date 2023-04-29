<?php

namespace Light2\Services;

class RequestService
{
    /**
     * Retrieves the message's request target.
     *
     * Retrieves the message's request-target either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI,
     * unless a value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * If no URI is available, and no request-target has been specifically
     * provided, this method MUST return the string "/".
     *
     * @return string
     */
    public function getRequestTarget(): string
    {
        return strtok(
            explode(
                $_ENV['baseURL'],
                $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
            )[1],
            '?'
        );
    }

    /**
     * Retrieves the HTTP method of the request.
     * @return string Returns the request method.
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     * @return string HTTP protocol version.
     */
    public function getProtocolVersion(): string
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    /**
     * Retrieves all message header values.
     *
     * The keys represent the header name as it will be sent over the wire, and
     * each value is an array of strings associated with the header.
     *
     * // Represent the headers as a string
     * foreach ($message->getHeaders() as $name => $values) {
     * echo $name . ": " . implode(", ", $values);
     * }
     *
     * // Emit headers iteratively:
     * foreach ($message->getHeaders() as $name => $values) {
     * foreach ($values as $value) {
     * header(sprintf('%s: %s', $name, $value), false);
     * }
     * }
     *
     * While header names are not case-sensitive, getHeaders() will preserve the
     * exact case in which headers were originally specified.
     * @return array<array> Returns an associative array of the message's headers. Each
     *                      key MUST be a header name, and each value MUST be an array of strings
     *                      for that header.
     */
    public function getHeaders(): array
    {
        return getallheaders();
    }

    /**
     * Checks if a header exists by the given case-insensitive name.
     *
     * @param string $name Case-insensitive header field name.
     * @return bool Returns true if any header names match the given header
     *              name using a case-insensitive string comparison. Returns false if
     *              no matching header name is found in the message.
     */
    public function hasHeader(string $name): bool
    {
        $header = $this->getHeaders();
        if (isset($header[$name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * This method returns an array of all the header values of the given
     * case-insensitive header name.
     *
     * If the header does not appear in the message, this method MUST return an
     * empty array.
     *
     * @param string $name Case-insensitive header field name.
     * @return array<string> An array of string values as provided for the given
     *                       header. If the header does not appear in the message, this method MUST
     *                       return an empty array.
     */
    public function getHeader(string $name): array
    {
        $header = $this->getHeaders();
        if (isset($header[$name])) {
            return $header[$name];
        } else {
            return [];
        }
    }

    /**
     * Gets the body of the message.
     * 
     */
    public function getBody()
    {
        return file_get_contents('php://input');
    }
}