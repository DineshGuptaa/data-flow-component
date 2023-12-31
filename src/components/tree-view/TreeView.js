import React, { useState } from 'react';

const TreeNode = ({ node, setData }) => {
    const [isExpanded, setIsExpanded] = useState(false);

    const handleToggle = () => {
        setIsExpanded(!isExpanded);
        console.log("SetExpande ===" + node.name);
        setData(node);
    };

    return (
        <div className="tree-node">
            <div onClick={handleToggle} className={`node-toggle ${isExpanded ? 'expanded' : ''}`}>
                {isExpanded && node.questions.length > 0 ? '-' : '+'} {node.name}
            </div>
            {isExpanded && (
                <ul className="child-nodes">
                    {node.questions.map((childNode) => (
                        <li key={childNode.question_id}>
                            <TreeNode node={childNode} setData={setData} />
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
};


const TreeView = ({ data, setData }) => {
    return (
        <div>
            {data.map((rootNode) => (
                <TreeNode key={rootNode.id} node={rootNode} setData={setData} />
            ))}
        </div>
    );
};

export default TreeView;