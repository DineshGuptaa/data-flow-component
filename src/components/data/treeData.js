const treeData = [
    {
        id: 1,
        name: 'root',
        children: [
            {
                id: 2,
                name: 'Topic 1',
                children: []
            },
            {
                id: 3,
                name: 'Topic 2',
                children: [
                    {
                        id: 4,
                        name: 'Topic 2.1',
                        children: []
                    },
                    {
                        id: 5,
                        name: 'Topic 2.2',
                        children: []
                    }
                ]
            },
            {
                id: 6,
                name: 'Topic 3',
                children: []
            },
            {
                id: 7,
                name: 'Topic 4',
                children: [
                    {
                        id: 6,
                        name: 'Topic 4.1',
                        children: []
                    },
                ]
            },
        ]
    }
];

export default treeData;