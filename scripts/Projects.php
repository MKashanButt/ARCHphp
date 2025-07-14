<?php

namespace ARCHphp\Scripts;

class Projects
{
    public function create(string $projectName = '')
    {
        if (empty($projectName)) {
            echo "❌ Project name is required.\n";
            exit(1);
        }

        $projectPath = getcwd() . DIRECTORY_SEPARATOR . $projectName;

        if (file_exists($projectPath)) {
            echo "❌ Directory '$projectName' already exists.\n";
            exit(1);
        }

        mkdir($projectPath, 0777, true);

        $skeletonPath = base_path('/../skeleton');

        // Copy skeleton into new project
        copyDir($skeletonPath, $projectPath);

        echo "Project '$projectName' created at $projectPath\n";
        echo "Next steps:\n";
        echo " - cd $projectName\n";
        echo " - composer install\n";
    }
}
