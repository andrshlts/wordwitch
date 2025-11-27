import { type RouteConfig, route } from '@react-router/dev/routes';

export default [
    // index('routes/home.tsx'),
    route(':lang?/', 'routes/home.tsx'),
    route(':lang?/refresh', 'routes/refresh-wordbase.tsx'),
] satisfies RouteConfig;