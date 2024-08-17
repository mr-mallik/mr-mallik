/** @type {import('next').NextConfig} */
const nextConfig = {
    output: 'export',
    images: {
        unoptimized: true,
        remotePatterns: [
            {
                protocol: 'https',
                hostname: 'cdn.pixabay.com',
            },
            {
                protocol: 'https',
                hostname: 'img.icons8.com',
            },
            {
                protocol: 'https',
                hostname: 'img.shields.io'
            }
        ],
    },
};

export default nextConfig;